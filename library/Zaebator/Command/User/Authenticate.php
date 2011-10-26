<?php
class Zaebator_Command_User_Authenticate extends Zaebator_Command_Abstract
{
	
	/**
	 * array of response callback - will be proccesed after geting response
	 * @var array 
	 */
	protected $_responseCallbacks = array('_setAuthHashCallback');
	
	protected function _setAuthHashCallback() {
		$this->_zaebator->setAuthHash($this->_result);
	}

	/**
	 * Set params as assoc array
	 * @param array $params 
	 */
	protected function setParams($params) {
		$this->_params = array(
			'user' => $this->_zaebator->getOption('user'),
			'password' => $this->_zaebator->getOption('password')
		);
	}
}
