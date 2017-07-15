<?php

#
# TEST1. カルーセル
#

class Controller_Calloga extends Controller_Rest
{

  public function post_index()
  {
    
    // LineBotインスタンスの作成
    $bot = new \LINE\LINEBot(
      new \LINE\LINEBot\HTTPClient\CurlHTTPClient(Config::get('linebot_info_oga.api.channel_token')),
      ['channelSecret' => Config::get('linebot_info_oga.api.channel_secret')]
    );

    // シグネチャ等取得
    $signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];  
    $body = file_get_contents('php://input');

    Log::info($signature);
    Log::info($body);

    // イベント取得（シグネチャからリクエストの検証を行う）
    $events = $bot->parseEventRequest($body, $signature);
    Log::info(print_r($events,true));

    // カルーセル型を返す
    foreach ($events as $event) {
      if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
                // リプライトークン発行
          $reply_token = $event->getReplyToken();
          
          $text = $event->getText();
          $bot->replyText($reply_token, $text);
          continue;
          // ポストアクション作成(4つまでok)
          $p_ac1 = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("ac1", "ac=1");
          $p_ac2 = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("ac2", "ac=2");
          $p_ac3 = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("ac3", "ac=3");
          $p_ac4 = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("ac4", "ac=4");
          
          $array_ac = array($p_ac1,$p_ac2,$p_ac3,$p_ac4); 
          
          // サムネイルURL(https)
          $thumbnail = "https://upload.wikimedia.org/wikipedia/commons/e/e5/HTTPS_icon.png";

          // ボタンテンプレート作成
          $btn = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder("title","description",$thumbnail,$array_ac); 

          // テンプレートメッセージ作成
          $btn_message = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("altTXT", $btn);
          
          // 送信
          $ret = $bot->replyMessage($reply_token, $btn_message);
                                        Log::info(print_r($ret,true));  
      }
    }
  }
}
