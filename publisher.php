<?php

require('./phpMQTT/phpMQTT.php');
require('./init.php');

class Publisher extends Controller_Rest {
  private $bot;
  private $signature;
  private $body;
  private $mqtt;

  public function __construct($val) {
    parent::__construct($val);

    // LineBotインスタンスの作成
    Config::load('linebot_info_oga', 'token');
    $client = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(Config::get('token.api.channel_token'));
    $this->bot = new \LINE\LINEBot($client, ['channelSecret' => Config::get('token.api.channel_secret')]);

    // シグネチャ取得
    $this->signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];  
    $this->body = file_get_contents('php://input');

    Log::info('Signature: ' . $this->signature);
    Log::info('Body: ' . $this->body);

    // MQTT コンストラクタの作成
    $this->mqtt = new phpMQTT($broker['host'], $broker['port'], 'publisher');
  }
  
  public function post_index() {
    // イベント取得（シグネチャからリクエストの検証を行う）
    $events = $this->bot->parseEventRequest($this->body, $this->signature);
    Log::info(print_r($events, true));

    foreach ($events as $event) {
      if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
        $reply_token = $event->getReplyToken();
          
        $text = $event->getText();
        if(strpos($text, '暑い') === false) {
          $this->bot->replyText($reply_token, $text);
        }
        else {
          $this->bot->replyText($reply_token, 'エアコンつけます');
          $this->send_mqtt('topic', 'msg'); #FIXME
        }

        # Log::info(print_r($ret,true));  
      }
    }
  }

  private function send_mqtt($topic, $msg) {
    if($mqtt->connect(true, null, $client['user'], $client['pass'])) {
        $mqtt->publish($topic, $msg, 0);
        $mqtt->close();
    }
  }
}

