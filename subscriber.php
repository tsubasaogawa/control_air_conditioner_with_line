<?php

require('./phpMQTT/phpMQTT.php');
require('./init.php');

$mqtt = new phpMQTT($broker['host'], $broker['port'], $client['name']);
if(!$mqtt->connect(true, null, $client['user'], $client['pass'])){
  exit(1);
}
$topics['ogawatest'] = array("qos"=>0, "function"=>"procmsg");
$mqtt->subscribe($topics,0);
while($mqtt->proc()){

}
$mqtt->close();
function procmsg($topic,$msg){
  echo "Msg Recieved: ".date("r")."\nTopic:{$topic}\n$msg\n";
}
