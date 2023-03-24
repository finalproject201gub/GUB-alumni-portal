<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_path',
        'linkedin_url',
        'github_url',
        'portfolio_url',
    ];
}
