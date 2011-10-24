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
	}

	public function setUrl($url) {
		$this->_options['url'] = $url;
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
	 *
	 * @param string $username
	 * @param string $password
	 * @return string 
	 */
	public function userAuthenticate($username = null, $password = null) {
		$args = func_get_args(); 
		return $this->_executeCommand('user.authenticate', $args);
	}

}