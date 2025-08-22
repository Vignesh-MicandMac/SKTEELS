<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotorRedeemedGifts extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'promotor_id',
        'dealer_id',
        'executive_id',
        'product_img',
    ];

    public function promotor()
    {
        return $this->belongsTo(Promotor::class, 'promotor_id');
    }

    public function dealer()
    {
        return $this->belongsTo(Dealers::class, 'dealer_id');
    }

    public function executive()
    {
        return $this->belongsTo(Executive::class, 'executive_id');
    }
}
