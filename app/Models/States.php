<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class States extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = ['id', 'state_code', 'state_name'];
    public function dealers()
    {
        return $this->hasMany(Dealers::class, 'state');
    }
}
