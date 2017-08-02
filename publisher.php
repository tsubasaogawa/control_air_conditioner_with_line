<?php

require('./phpMQTT/phpMQTT.php');
require('./init.php');

$mqtt = new phpMQTT($broker['host'], $broker['port'], 'publisher'); //Change client name to something unique
if ($mqtt->connect()) {
    $mqtt->publish('ogawatest', 'remocon!', 0);
    $mqtt->close();
}
