<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;



    protected $fillable = [
        'name',
        'coordinator',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'zip',
        'details',
        'date',
        'time',
        'publish_filter',
        'image'
    ];




}
