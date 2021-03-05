<?php 

namespace App\Domain\UseCases;

use App\Domain\TelegramMessageModel;
use Telegram\Bot\Laravel\Facades\Telegram;

class ReplyToNapalm {

  private $telegramMessage;

  public function __construct(TelegramMessageModel $telegramMessage)
  {
    $this->telegramMessage = $telegramMessage;
  }

  public function __invoke() {

    $text = $this->telegramMessage->getText();

    if(strpos($text, 'napalm') !== false) {
      Telegram::sendMessage([
        'chat_id' => $this->telegramMessage->getChatId(),
        'text' => config('botmalandriner.reply_napalm'),
        'parse_mode' => 'MarkdownV2'
      ]);
    }

  }
  

}