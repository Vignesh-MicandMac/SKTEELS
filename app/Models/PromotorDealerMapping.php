<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PromotorDealerMapping extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['promotor_id', 'dealer_id'];

    public function promotor()
    {
        return $this->belongsTo(Promotor::class, 'promotor_id');
    }

    public function dealer()
    {
        return $this->belongsTo(Dealers::class, 'dealer_id');
    }
}
