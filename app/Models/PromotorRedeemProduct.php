<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotorRedeemProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'promotor_id',
        'dealer_id',
        'executive_id',
        'product_id',
        'product_code',
        'product_name',
        'redeemed_date',
        'promotor_points',
        'product_redeem_points',
        'balance_promotor_points',
        'approved_status',
        'declined_reason',
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

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
