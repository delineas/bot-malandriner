<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageLink extends Model
{
    protected $table = 'messages_links';

    protected $fillable = [
        'link', 'hashtag', 'username'
    ];
}
