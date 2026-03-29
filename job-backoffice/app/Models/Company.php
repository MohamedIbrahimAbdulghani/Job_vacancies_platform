<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Company extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'companies';

    protected $keyType = "string";

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'address',
        'industry',
        'website',
        'owner_id'
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

    // this function to make relationship one to many between user( owner ) and company
    public function user() {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function Jobvacancy() {
        return $this->hasMany(JobVacancy::class, 'company_id', 'id');
    }

    public function jobApplications() {
        return $this->hasManyThrough(JobApplication::class, JobVacancy::class, 'company_id', 'job_vacancy_id', 'id', 'id');
    }
}
