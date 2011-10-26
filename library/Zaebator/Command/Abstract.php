<?php

class Zaebator_Command_Abstract implements Zaebator_Command_Interface {

	/**
	 *
	 * @var Zaebator 
	 */
	protected $_zaebator;

	/**
	 *
	 * @var string 
	 */
	protected $_method;

	/**
	 *
	 * @var string 
	 */
	protected $_params;

	/**
	 *
	 * @var integer 
	 */
	protected static $_increment = 1;


	/**
	 * array of response callback - will be proccesed after geting response
	 * @var array 
	 */
	protected $_responseCallbacks = array();

	/**
	 *
	 * @var array 
	 */
	protected $_result;

	/**
	 * Constructor
	 * 
	 * @param Zaebator $zaebator   Zaebator instance
	 * @param string  $method      Command name
	 * @param array   $params Command arguments
	 */
	public function __construct(Zaebator $zaebator, $method, $params = array()) {
		$this->_zaebator = $zaebator;
		$this->_method = $method;
		$this->setParams($params);
	}

	/**
	 * Set params as assoc array
	 * @param array $params 
	 */
	protected function setParams($params) {
		$this->_params = $params;
	}

	/**
	 *
	 * @return string 
	 */
	protected function _buildJSONRequest() {
		$request = array(
			'auth' => $this->_zaebator->getAuthHash(),
			'method' => $this->_method,
			'id' => $this->_updateCommandIncrement(),
			'params' => ( is_array($this->_params) ? $this->_params : array() ),
			'jsonrpc' => "2.0"
		);
		return json_encode($request);
	}

	public function execute() {
		if ($this->_zaebator->getAuthHash() == NULL && $this->_method != 'user.authenticate') {
			throw new Zaebator_Exception('Not authorized');
		}
		$requestJSONData = $this->_buildJSONRequest();
		$data = Zaebator_Request::instance($this->_zaebator)->exec($requestJSONData);

		return $this->_getResponse($data);
	}

	protected function _getResponse($data) {
		// Convert return data (JSON) to PHP array
		$response = json_decode($data, true);
		$this->_result = $response['result'];
		$this->_proccResponseCallbacks();
		return $this->_result;
	}

	protected function _proccResponseCallbacks() {
		foreach ($this->_responseCallbacks as $callback) {
			call_user_func(array($this, $callback));
		}
		$this->_responseCallbacks = array();
	}

	private function _updateCommandIncrement() {

		self::$_increment++;
		return self::$_increment;
	}

	private function _getCommandIncrement() {

		return self::$_increment;
	}

}
