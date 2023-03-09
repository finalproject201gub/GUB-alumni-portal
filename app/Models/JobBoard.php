<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobBoard extends Model
{
    use HasFactory;

    protected $table = "job_boards";

    protected $fillable = [
        "user_id",
        "company_name",
        "title",
        "description",
        "vacancy",
        "experience_requirements",
        "education_requirements",
        "company_information",
        "image",
        "tags",
        "job_type",
        "salary",
        "location",
        "application_deadline",
        "approve_status",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
