<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;

class FileScan extends Model
{
    protected $table = 'pro_network_file_scans';
    protected $fillable = ['path','status','details'];
    protected $casts = [
        'details' => 'array',
    ];
}
