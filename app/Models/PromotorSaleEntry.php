<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PromotorSaleEntry extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'promoter_id',
        'dealer_id',
        'executive_id',
        'quantity',
        'approved_status',
        'obtained_points'
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
