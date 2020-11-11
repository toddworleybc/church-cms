<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teaching extends Model
{
    use HasFactory;



    protected $fillable = [
        'title',
        'staff_id',
        'speaker',
        'video',
        'audio',
        'scripture',
        'publish_date',
        'description',
        'ft_img',
        'status'
    ];


}
