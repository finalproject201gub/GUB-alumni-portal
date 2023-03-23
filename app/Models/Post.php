<?php

namespace App\Models;

use App\Traits\CommonGlobal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    // use CommonGlobal;    

    protected $fillable = [
        'user_id',
        'content',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    const STATUS = [
        'ACTIVE' => 1,
        'INACTIVE' => 0,
    ];

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS['ACTIVE']);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS['INACTIVE']);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
