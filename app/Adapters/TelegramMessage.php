<?php

namespace App\Adapters;

use Telegram\Bot\Objects\Update;

class TelegramMessage implements MessengerMessageInterface {

  private $update;

  public function __construct(Update $update) {
    $this->update = $update;
  }

  public function getText() {
    if(!isset($this->update->getMessage()['text'])) {
      throw new \Exception("No text in TelegramMessage", 1);
    }

    return $this->update->getMessage()['text'];

  }

  public function getChatId() {
    return $this->update->getChat()['id'];
  }
}