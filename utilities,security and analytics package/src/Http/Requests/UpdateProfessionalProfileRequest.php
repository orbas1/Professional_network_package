<?php

namespace ProNetwork\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfessionalProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'headline' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
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
            'public_url' => 'nullable|string|max:255',
            'interests' => 'array',
        ];
    }
}
