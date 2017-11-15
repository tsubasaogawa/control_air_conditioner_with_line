<?php

class Init {
  private $broker;
  private $client;

  public function __construct() {
    $json = file_get_contents(dirname(__FILE__) . '/secrets.json');
    $secrets = json_decode($json, true);
    $this->broker = $secrets['broker'];
    $this->client = $secrets['client'];
  }

  public function get_broker() {
    return $this->broker;
  }

  public function get_client() {
    return $this->client;
  }
}
