<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class RolePermission extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'role_permissions';

    protected $fillable = [
        'role_id',
        'permission_id'
    ];
}
