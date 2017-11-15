<?php

require('./phpMQTT/phpMQTT.php');
require('./init.php');

class Publisher {
  private $mqtt;

  public function __construct($val) {
    // MQTT コンストラクタの作成
    $this->mqtt = new phpMQTT($broker['host'], $broker['port'], 'publisher');
  }

  private function send_mqtt($topic, $msg) {
    if($mqtt->connect(true, null, $client['user'], $client['pass'])) {
        $mqtt->publish($topic, $msg, 0);
        $mqtt->close();
    }
  }
}

