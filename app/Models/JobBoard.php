<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBoard extends Model
{
    use HasFactory;

    protected $table = "job_boards";

    protected $fillable = [
        "user_id",
        "title",
        "description",
        "image",
        "tags",
        "job_type",
        "salary",
        "location",
        "application_deadline",
        "approve_status",
    ];
}
