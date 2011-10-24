<?
require './library/Zaebator.php';
$option = array(
	'url' => 'http://zabbixhost/zabbix/api_jsonrpc.php'
);
$zaebator = new Zaebator($option);

$result = $zaebator->userAuthenticate('user', 'password');
