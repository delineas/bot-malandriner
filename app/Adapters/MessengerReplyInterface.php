<?php

namespace App\Adapters;

interface MessengerReplyInterface {

  public function setText($text);

  public function setChatId($chatId);

  public function setFormat($format);

  public function getReply();

}