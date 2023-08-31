<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $dates = ['deleted_at'];


    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function transactions(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function getIsSoldAttribute()
    {
        return $this->transactions?->where('unit_id', $this->id)->exists();
    }

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['type'] ?? false, function ($query, $type) {
            $query->where('type', $type);
        });
        $query->when($filters['location'] ?? false, function ($query, $location) {
            $query->where('location', $location);
        });
        $query->when($filters['number_of_rooms'] ?? false, function ($query, $number_of_rooms) {
            $query->where('number_of_rooms', $number_of_rooms);
        });
        $query->when($filters['number_of_bathrooms'] ?? false, function ($query, $number_of_bathrooms) {
            $query->where('number_of_bathrooms', $number_of_bathrooms);
        });
        $query->when($filters['area'] ?? false, function ($query, $area) {
            $query->where('area', $area);
        });

    }
}
