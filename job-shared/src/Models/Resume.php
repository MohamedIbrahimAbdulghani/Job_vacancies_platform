<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\JobApplication;

class Resume extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'resumes';

    protected $keyType = "string";

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'filename',
        'fileUrl',
        'contactDetails',
        'education',
        'summary',
        'skills',
        'experience',
        'user_id'
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

    // this function to make relationship one to many between user and resumes
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jobapplication() {
        return $this->hasMany(JobApplication::class, 'resume_id', 'id');
    }
}