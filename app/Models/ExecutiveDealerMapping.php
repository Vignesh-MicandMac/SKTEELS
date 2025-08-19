<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ExecutiveDealerMapping extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['executive_id', 'dealer_id'];

    public function executive()
    {
        return $this->belongsTo(Executive::class);
    }

    public function dealer()
    {
        return $this->belongsTo(Dealers::class, 'dealer_id');
    }
}
