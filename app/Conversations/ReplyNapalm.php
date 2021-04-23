<?php 

namespace App\Conversations;

class ReplyNapalm {

  private $answerMessage;

  public function __construct($answerMessage) {
    $this->answerMessage = $answerMessage;
  }

  public function answer($input) {
    if(strpos($input, 'napalm') !== false) {
      return $this->answerMessage;
    }
    return '';
  }

}