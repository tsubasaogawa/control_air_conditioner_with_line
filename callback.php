<?php

require('./publisher.php');

class Controller_callback extends Controller_Rest {
  private $publisher;

  public function __construct($val) {
    parent::__construct($val);
    $this->publisher = new Publisher();
  }
  
  public function post_index() {
    Log::info('Receive from Dialogflow!');
    $form = Input::json();
    # result -> resolvedQuery: Inputted text by user
    var_dump($form['result']['resolvedQuery']);
    $this->publisher->send_mqtt('topic', 'msg'); #FIXME
  }

  public function get_index() {
    Log::info('Receive get data');
  }
}
