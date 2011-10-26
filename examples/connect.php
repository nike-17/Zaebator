<?

require './../library/Zaebator.php';
$option = array(
	'url' => 'http://zabbixhost/zabbix/api_jsonrpc.php',
	'user' => 'user',
	'password' => 'password'
);
$zaebator = new Zaebator($option);

$result = $zaebator->userAuthenticate();
