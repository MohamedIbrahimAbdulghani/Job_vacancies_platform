<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Company;
use App\Models\JobCategory;

class JobVacancy extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'job_vacancies';

    protected $keyType = "string";

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'company_id',
        'category_id'
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

    // this function to make relationship one to many between companies and job_vacancies
    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    // this function to make relationship one to many between job_categories and job_vacancies
    public function jobcategory() {
        return $this->belongsTo(JobCategory::class, 'category_id', 'id');
    }

    public function Jobapplication() {
        return $this->hasMany(JobApplication::class, 'job_vacancy_id', 'id');
    }
}
