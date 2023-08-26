<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function images(){
        return $this->hasMany(Image::class);
    }
    public function transactions(){
        return $this->hasOne(Transaction::class);
    }

}
