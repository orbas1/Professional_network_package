<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;

class BadWord extends Model
{
    protected $table = 'pro_network_bad_words';
    protected $fillable = ['phrase'];
}
