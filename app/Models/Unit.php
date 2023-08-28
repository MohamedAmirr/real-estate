<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['is_sold'];
    private bool $is_sold = false;

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function transactions()
    {
        return $this->hasOne(Transaction::class);
    }

    public function getIsSoldAttribute($value)
    {
        return $this->transactions->where('unit_id', $this->id)->exists();
    }
}
