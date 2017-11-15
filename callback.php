<?php

class Controller_Calloga extends Controller_Rest {
  public function __construct($val) {
    parent::__construct($val);
    Log::info('constructor start');
  }
  
  public function post_index() {
    Log::info('Receive from Dialogflow!');
    $form = Input::json();
    # result -> resolvedQuery: Inputted text by user
    var_dump($form['result']['resolvedQuery']);
  }

  public function get_index() {
    Log::info('Receive get data');
  }
}
