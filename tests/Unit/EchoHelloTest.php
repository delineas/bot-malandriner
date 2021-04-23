<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Conversations\EchoHello;

class EchoHelloTest extends TestCase
{

    public function test_cuando_dice_hola_respondo_hola() {
        $conversation  = new EchoHello();
        $answer = $conversation->answer('hola');

        $this->assertEquals('hola', $answer);
    }

    public function test_cuando_dice_otra_cosa_diferente_a_hola_no_respondo_hola() {
        $conversation  = new EchoHello();
        $answer = $conversation->answer('otra cosa');

        $this->assertEquals('', $answer);

    }
}
