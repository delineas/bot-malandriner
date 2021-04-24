<?php 

namespace App\Domain\UseCases;

use App\Adapters\ConfigAdapter;
use App\Adapters\MessengerReplyInterface;
use App\Adapters\MessengerMessageInterface;


class ReplyToNapalm {

  private $messengerMessage;
  private $messengerReply;
  private $config;

  public function __construct(MessengerMessageInterface $messengerMessage, MessengerReplyInterface $messengerReply, ConfigAdapter $config) {
    $this->messengerMessage = $messengerMessage;
    $this->messengerReply = $messengerReply;
    $this->config = $config;
  }

  public function __invoke() {

    $text = $this->messengerMessage->getText();

    if(strpos($text, 'napalm') !== false) {
      $this->messengerReply->setText($this->config->get('botmalandriner.reply_napalm'));
      $this->messengerReply->setChatId($this->messengerMessage->getChatId());
      return $this->messengerReply->getReply();
    }

  }
  

}