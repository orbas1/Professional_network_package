<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfessionalProfile extends Model
{
    protected $table = 'pro_network_professional_profiles';
    protected $fillable = [
        'user_id','headline','location','top_skills','skills','certifications','work_history','education','references','dbs','gigs','projects','jobs','available_for_work','public_url','connections_count','interests'
    ];
    protected $casts = [
        'top_skills' => 'array',
        'skills' => 'array',
        'certifications' => 'array',
        'work_history' => 'array',
        'education' => 'array',
        'references' => 'array',
        'dbs' => 'array',
        'gigs' => 'array',
        'projects' => 'array',
        'jobs' => 'array',
        'available_for_work' => 'boolean',
        'interests' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', \App\Models\User::class));
    }
}
