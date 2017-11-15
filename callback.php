<?php

require(dirname(__FILE__) . '/publisher.php');

class Controller_callback extends Controller_Rest {
  private $publisher;

  public function __construct($val) {
    parent::__construct($val);
    $this->publisher = new Publisher();
  }
  
  public function post_index() {
    $json = Input::json();
    $text = $json['result']['resolvedQuery']; 
    # Fail: Default Fallback Intent, Success: turn-on-air-conditioner-cold
    $aircon_flag = $json['result']['metadata']['intentName'] == 'turn-on-air-conditioner-cold' ? true : false;
    Log::info('intentName: ' . $json['result']['metadata']['intentName']);
    if($aircon_flag) {
      $this->publisher->send_mqtt('ogawatest', date('Ymd His') . ' aircon');
      Log::info('Send MQTT');
    }
  }

  public function get_index() {
    Log::info('Receive get data');
  }
}
