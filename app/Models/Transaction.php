<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['user_id'] ?? false, function ($query, $user_id) {
            $query->where('user_id', $user_id);
        });
    }
}
