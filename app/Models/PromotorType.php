<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PromotorType extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['promotor_type', 'is_active'];
}
