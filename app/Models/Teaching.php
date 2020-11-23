<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teaching extends Model
{
    use HasFactory;



    protected $fillable = [
        'type',
        'title',
        'staff_id',
        'speaker',
        'video',
        'audio',
        'scripture',
        'publish_date',
        'description',
        'ft_image',
        'status'
    ];


}
