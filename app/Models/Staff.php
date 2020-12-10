<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'position',
        'pastor',
        'bio',
        'image'
    ];



    public function teachings() {
        return $this->hasMany('App\Models\Teaching');
    }



}
