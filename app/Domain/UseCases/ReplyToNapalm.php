<?php 

namespace App\Domain\UseCases;

use App\Adapters\MessengerReplyInterface;
use App\Adapters\MessengerMessageInterface;


class ReplyToNapalm {

  private $messengerMessage;
  private $messengerReply;

  public function __construct(MessengerMessageInterface $messengerMessage, MessengerReplyInterface $messengerReply) {
    $this->messengerMessage = $messengerMessage;
    $this->messengerReply = $messengerReply;
  }

  public function __invoke() {

    $text = $this->messengerMessage->getText();

    if(strpos($text, 'napalm') !== false) {
      $this->messengerReply->setText('napalm responde');
      $this->messengerReply->setChatId($this->messengerMessage->getChatId());
      return $this->messengerReply->getReply();
    }

  }
  

}