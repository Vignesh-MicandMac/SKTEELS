<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'product_name',
        'product_code',
        'description',
        'img_path',
        'points',
        'availability',
        'is_active',
    ];
}
