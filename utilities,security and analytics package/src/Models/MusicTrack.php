<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;

class MusicTrack extends Model
{
    protected $table = 'pro_network_music_tracks';
    protected $fillable = ['title','artist','url','license'];
}
