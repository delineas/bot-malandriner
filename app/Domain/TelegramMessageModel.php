<?php 

namespace App\Domain;

class TelegramMessageModel {

  private $message;
  private $updateId;

  public function __construct(array $request) {
    $this->updateId = $request['update_id'];
    $this->message = $request['message'];
  } 

  public function getUpdateId() {
    return $this->updateId;
  }

  public function getMessageId() {
    return $this->message['message_id'];
  }

  public function getChatId() {
    return $this->message['chat']['id'];
  }

  public function getUserId() {
    return $this->message['from']['id'];
  }

  public function isTextMessage() {
    return isset($this->message['text']);
  }

  public function getText() {
    if($this->isTextMessage()) {
      return $this->message['text'];
    }
    return '';
  }



}