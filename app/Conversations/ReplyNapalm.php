<?php 

namespace App\Conversations;

use App\Conversations\ReplyInterface;

class ReplyNapalm implements ReplyInterface {

  private $answerMessage;

  public function __construct($answerMessage) {
    $this->answerMessage = $answerMessage;
  }

  public function answer($input) {
    if(strpos($input, 'napalm') !== false) {
      return $this->answerMessage;
    }
    return false;
  }

}