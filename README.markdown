# Zaebator - Zabbix API wrapper skeleton
Zabbix is an enterprise-class open source distributed monitoring solution with JSON-RPC based Zabbix API.
ZAEBATOR - is a skeleton for this  JSON-RPC API. Right now i do only few commands - but it's no problem to implement other methods.
You can do it by your self or feel free to ask my (nike-17@ya.ru).

## Support Commands

Sea examples folder.

## Requirements

* PHP 5.3 with curl support

## Installation

Step 0: Download this code!

You can always download the code from the [github project](http://github.com/nike-17/Zaebator) as an archive.


Step 1: Just create an instance of Zaebator

	<?
	require './library/Zaebator.php';
	$option = array(
		'url' => 'http://zabbixhost/zabbix/api_jsonrpc.php'
	);
	$zaebator = new Zaebator($option);

	$result = $zaebator->userAuthenticate('user', 'password');


Step 3: Add your request method than you need

Step 3.1: Add to Zaebator main class (library/Zaebator.php)

	public function yourMethod($param1, $param2, ..,$paramn) {
		$args = func_get_args(); 
		return $this->_executeCommand('your.method', $args);
	}
	
Step 3.2: Add to Zaebator Commands  class (library/Zaebator/Commands.php)

	protected static $_commands = array(
		'user.authenticate' => 'Zaebator_Command_User_Authenticate',
			.....
		'your.method' => 'Zaebator_Command_Your_Method'
	);

Step 3.3: Add  Zaebator Command  class (library/Zaebator/Your/Method.php)
see Zaebator_Command_User_Authenticate as example
anyway all you need in this class add params map
		
	protected $_paramsMap = array('param1', 'param2', ...,'paramn');
And you can add responseCallback(s) id you need to call some kind of callbacks

	protected $_responseCallbacks = array('_setAuthHashCallback');
	
	protected function _setAuthHashCallback() {
		$this->_zaebator->setAuthHash($this->_result);
	}

Step 4: Have some trouble?Feel free to asq me here on github or via email nike-17@ya.ru 