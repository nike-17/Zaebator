<?php

// Register autoloader
require_once dirname(__FILE__) . '/Zaebator/Autoloader.php';
Zaebator_Autoloader::register();

class Zaebator extends Zaebator_Options {
	const PHPAPI_VERSION = '1.8';
	/**
	 *
	 * @var string 
	 */
	protected $_authHash;

	public function __construct(array $options = array()) {
		parent::__construct($options);
		$this->_initOptions();
	}

	protected function _initOptions() {
		if (!$this->isOptionSet('urlApi')) {
			$this->setOption('urlApi', $this->getOption('url') . "api_jsonrpc.php");
		}
		
		if (!$this->isOptionSet('urlGraph')) {
			$this->setOption('urlGraph', $this->getOption('url') . "chart2.php");
		}

		if (!$this->isOptionSet('urlIndex')) {
			$this->setOption('urlIndex', $this->getOption('url') . "index.php");
		}
	}

	public function setUrlGraph($urlGraph) {
		$this->_options['urlGraph'] = $urlGraph;
	}

	public function setUrlIndex($urlIndex) {
		$this->_options['urlIndex'] = $urlIndex;
	}

	public function setUrl($url) {
		$this->_options['url'] = $url;
	}
	
	public function setUrlApi($url) {
		$this->_options['urlApi'] = $url;
	}

	public function setUser($user) {
		$this->_options['user'] = $user;
	}
	public function setPassword($password) {
		$this->_options['password'] = $password;
	}

	public function getAuthHash() {
		return $this->_authHash;
	}

	public function setAuthHash($value) {
		$this->_authHash = $value;
	}

	/**
	 * Magic method for execute command
	 *
	 * @param string $name Command name
	 * @param array  $args  Command arguments
	 * @return mixed
	 */
	public function __call($name, $args) {
		return $this->_executeCommand($name, $args);
	}

	/**
	 * Execute command
	 *
	 * @param string $name Command name
	 * @param array  $args  Command arguments
	 * @return mixed
	 */
	protected function _executeCommand($name, $args = array()) {
		$command = Zaebator_Commands::get($this, $name, $args);
		$response = $command->execute();

		unset($command);

		return $response;
	}

	/**
	 * @return type 
	 */
	public function userAuthenticate() {
		return $this->_executeCommand('user.authenticate');
	}

	public function graphGet($params) {
		return $this->_executeCommand('graph.get', $params);
	}

}