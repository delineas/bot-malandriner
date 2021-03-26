<?php

namespace App\Domain\UseCases;

use Telegram\Bot\Objects\Update;
use Telegram\Bot\Laravel\Facades\Telegram;

class WelcomeNewUser {

  private $update;

  public function __construct(Update $update) {
    $this->update = $update;
  }

  public function __invoke()  {

    if(!isset($this->update->getMessage()['new_chat_members'])) {
      return;
    }

    $from = $this->update->getMessage()['from'];

    $welcomeMessage = str_replace(
      ['@first_name' , '@last_name'], 
      [$from['first_name'], (isset($from['last_name']) ? $from['last_name'] : '')], 
      config('botmalandriner.welcome_new_user')
    );

    Telegram::sendMessage([
      'chat_id' => $this->update->getChat()['id'],
      'text' => $welcomeMessage,
      'parse_mode' => 'MarkdownV2'
    ]);
    
  }

}