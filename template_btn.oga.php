<?php

class Controller_Calloga extends Controller_Rest {
  private $bot;
  private $signature;
  private $body;

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
          else { $this->bot->replyText($reply_token, 'エアコンつけます'); }

          # Log::info(print_r($ret,true));  
      }
    }
  }
}
