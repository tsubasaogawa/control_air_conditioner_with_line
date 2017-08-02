<?php

require('./phpMQTT/phpMQTT.php');
require('./init.php');

$mqtt = new phpMQTT($broker['host'], $broker['port'], 'publisher');
if($mqtt->connect(true, null, $client['user'], $client['pass'])) {
    $mqtt->publish('ogawatest', 'remocon!', 0);
    $mqtt->close();
}
