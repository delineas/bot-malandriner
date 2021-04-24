<?php 

namespace App\Domain\UseCases;

use App\Adapters\MessengerMessageInterface;


class ReplyToNapalm {

  private $messengerMessage;

  public function __construct(MessengerMessageInterface $messengerMessage) {
    $this->messengerMessage = $messengerMessage;
  }

  public function __invoke() {

    $text = $this->messengerMessage->getText();

    if(strpos($text, 'napalm') !== false) {
      return [
        'chat_id' => $this->messengerMessage->getChatId(),
        'text' =>  'napalm responde', //config('botmalandriner.reply_napalm'),
        'parse_mode' => 'MarkdownV2'
      ];
    }

  }
  

}