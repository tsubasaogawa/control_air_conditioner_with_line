<?php

require(dirname(__FILE__) . '/phpMQTT/phpMQTT.php');
require(dirname(__FILE__) . '/init.php');

class Publisher {
  private $init;
  private $mqtt;

  public function __construct() {
    $this->init = new Init();
    $broker = $this->init->get_broker();
    # MQTT オブジェクトを作成
    $this->mqtt = new phpMQTT($broker['host'], $broker['port'], 'publisher');
  }

  # topic/msg を受け取って MQTT を送信
  public function send_mqtt($topic, $msg) {
    $client = $this->init->get_client();
    if($this->mqtt->connect(true, null, $client['user'], $client['pass'])) {
        $this->mqtt->publish($topic, $msg, 0);
        $this->mqtt->close();
    }
  }
}

