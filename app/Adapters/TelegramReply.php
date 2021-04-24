<?php

namespace App\Adapters;

use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramReply implements MessengerReplyInterface {
  
  private $chatId;
  private $text;
  private $parse_mode = 'MarkdownV2';

  public function setText($text) {
    $this->text = $text;
  }

  public function setChatId($chatId) {
    $this->chatId = $chatId;
  }

  public function setFormat($format) {
    $this->parse_mode = $format;
  }

  public function getReply() {
    if(empty($this->text) || empty($this->chatId)) {
      throw new \Exception("Text or chat id is not completed", 1);
    }
    //
    return [
      'chat_id' => $this->chatId,
      'text' => $this->text,
      'parse_mode' => $this->parse_mode,
    ];
  }

}