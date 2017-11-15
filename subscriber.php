<?php

require(dirname(__FILE__) . '/phpMQTT/phpMQTT.php');
require(dirname(__FILE__) . '/init.php');

$mqtt = new phpMQTT($broker['host'], $broker['port'], 'subscriber');
if(! $mqtt->connect(true, null, $client['user'], $client['pass'])) {
  exit(1);
}
$topics['ogawatest'] = array("qos" => 0, "function" => "procmsg");
$mqtt->subscribe($topics, 0);
while($mqtt->proc()) {
  sleep(1);
}

$mqtt->close();

function procmsg($topic,$msg) {
  echo "Msg Recieved: ".date("r")."\nTopic:{$topic}\n$msg\n";
}
