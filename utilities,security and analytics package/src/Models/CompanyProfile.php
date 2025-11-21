<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyProfile extends Model
{
    protected $table = 'pro_network_company_profiles';
    protected $fillable = ['page_id','headline','metadata','employee_count'];
    protected $casts = [
        'metadata' => 'array',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Page::class);
    }
}
