<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dealers extends Model
{
  use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

  protected $fillable = [
    'tally_dealer_id',
    'name',
    'role',
    'address',
    'pincode',
    'state',
    'area',
    'district',
    'action',
    'mobile',
    'password',
    'gst_no',
    'otp',
    'otp_expired_at',
    'created_at',
    'updated_at',
  ];

  protected $dates = ['deleted_at'];

  public function states()
  {
    return $this->belongsTo(States::class, 'state');
  }

  public function districts()
  {
    return $this->belongsTo(District::class, 'district');
  }

  public function promotorMappings()
  {
    return $this->hasMany(PromotorDealerMapping::class, 'dealer_id');
  }
}
