<?php

namespace App\Adapters;

use Illuminate\Support\Facades\Config;

class ConfigAdapter {

  public function get($key) {
    dump('hola');
    return Config::get($key);
  }
}