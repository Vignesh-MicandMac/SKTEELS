<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class District extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = ['state_id', 'district_name'];

    public function state()
    {
        return $this->belongsTo(States::class);
    }

    public function dealers()
    {
        return $this->hasMany(Dealers::class, 'district');
    }
}
