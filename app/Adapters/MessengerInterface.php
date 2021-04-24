<?php

namespace App\Adapters;

interface MessengerInterface {

  public function setMessage(MessengerMessageInterface $message);

  public function setReply(MessengerReplyInterface $reply);

  public function sendReply();
  
}