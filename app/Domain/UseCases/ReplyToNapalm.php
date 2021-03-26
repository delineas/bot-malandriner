<?php 

namespace App\Domain\UseCases;

use Telegram\Bot\Objects\Update;
use Telegram\Bot\Laravel\Facades\Telegram;

class ReplyToNapalm {

  private $update;

  public function __construct(Update $update)
  {
    $this->update = $update;
  }

  public function __invoke() {

    $text = $this->update->getMessage()['text'];

    if(strpos($text, 'napalm') !== false) {
      Telegram::sendMessage([
        'chat_id' => $this->update->getChat()['id'],
        'text' => config('botmalandriner.reply_napalm'),
        'parse_mode' => 'MarkdownV2'
      ]);
    }

  }
  

}