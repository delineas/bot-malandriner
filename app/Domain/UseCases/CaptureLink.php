<?php

namespace App\Domain\UseCases;

use App\MessageLink;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Laravel\Facades\Telegram;

class CaptureLink
{

  private $update;

  public function __construct(Update $update)
  {
    $this->update = $update;
  }

  public function __invoke()
  {

    if (!isset($this->update->getMessage()['text'])) {
      return;
    }

    $text = $this->update->getMessage()['text'];
    $from = $this->update->getMessage()['from'];

    $regex = '/(https?:\/\/[a-z0-9.\?\=#_\/-]*)/m';

    $results = preg_match_all($regex, $text, $matches, PREG_SET_ORDER, 0);

    if(!$results) {
      return;
    }

    $link = $matches[0][0];

    MessageLink::create([
      'link' => $link,
      'hashtag' => '',
      'username' => $from['username'],
    ]);

    Telegram::sendMessage([
      'chat_id' => $this->update->getChat()['id'],
      'text' => 'El bot malandriner ha capturado tu enlace',
      'parse_mode' => 'MarkdownV2'
    ]);

  }
}
