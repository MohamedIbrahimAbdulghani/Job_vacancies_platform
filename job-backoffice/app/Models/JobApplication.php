<?php

namespace App\Models;

use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'job_applications';

    protected $keyType = "string";

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aiGeneratedFeedback',
        'user_id',
        'resume_id',
        'job_vacancy_id'
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }
    // this function to make relationship one to many between user and job_applications
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // this function to make relationship one to many between resumes and job_applications
    public function resume() {
        return $this->belongsTo(Resume::class, 'resume_id', 'id');
    }

    // this function to make relationship one to many between job_vacancies and job_applications
    public function jobvacancy() {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id', 'id');
    }

}
