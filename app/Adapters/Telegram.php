<?php

namespace App\Adapters;

use Telegram\Bot\Laravel\Facades\Telegram as TelegramSDK;

class Telegram implements MessengerInterface {
  
  private $messenger;
  private $messengerMessage;
  private $messengerReply;

  public function __construct(TelegramSDK $telegram, MessengerMessageInterface $messengerMessage, MessengerReplyInterface $messengerReply) {
    $this->messenger = $telegram;
    $this->setMessage($messengerMessage);
    $this->setReply($messengerReply);
  }

  public function setMessage(MessengerMessageInterface $messengerMessage) {
    $this->messengerMessage = $messengerMessage;
  }
  public function setReply(MessengerReplyInterface $messengerReply) {
    $this->messengerReply = $messengerReply;
  }

  public function sendReply() {
    $this->messenger::sendMessage($this->messengerReply->getReply());
  }

}