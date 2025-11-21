<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AccountType extends Model
{
    protected $table = 'pro_network_account_types';
    protected $fillable = ['name','features'];
    protected $casts = [
        'features' => 'array',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(config('auth.providers.users.model', \App\Models\User::class), 'pro_network_user_account_types', 'account_type_id', 'user_id');
    }
}
