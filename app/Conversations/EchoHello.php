<?php 

namespace App\Conversations;

class EchoHello {

  public function answer($input) {
    if($input == 'hola') {
      return 'hola';
    }
    return '';
  }
}