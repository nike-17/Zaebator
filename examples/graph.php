<?

require './../library/Zaebator.php';
$option = array(
	'url' => 'http://zabbixhost/zabbix/api_jsonrpc.php',
	'user' => 'user',
	'password' => 'password'
);
$zaebator = new Zaebator($option);

$zaebator->userAuthenticate();


$params = array(
	"hostids" => array('6666666666666666666')
);

$result = $zaebator->graphGet($params);

$graphcontent = array();

foreach ($result as $item) {
	$graphid = $item['graphid'];
	$content = Zaebator_Service_Graph::getGraphImageById($zaebator, $graphid);
	$base64 = base64_encode($content);
	$graphcontent[] = ('data: image/png ; base64,' . $base64);
}

foreach ($graphcontent as $graph) {
	echo "<img src='{$graph}' >";
}