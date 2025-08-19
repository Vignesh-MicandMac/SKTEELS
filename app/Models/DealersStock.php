<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class DealersStock extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'dealer_id',
        'open_balance',
        'dispatch',
        'total_stock',
        'dispatch_date',
        'promoter_sales',
        'balance_stock',
        'closing_stock',
        'other_sales',
        'declined_stock',
        'date_of_declined',
        'total_current_stock',
        'closing_stock_updated_at'
    ];


    protected $casts = [
        'dispatch_date' => 'date',
        'date_of_declined' => 'date',
        'closing_stock_updated_at' => 'date'
    ];

    public function dealer()
    {
        return $this->belongsTo(Dealers::class, 'dealer_id');
    }
}
