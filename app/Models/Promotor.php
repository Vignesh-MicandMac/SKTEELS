<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Promotor extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'enroll_no',
        'executive_id',
        'name',
        'img_path',
        'promotor_type_id',
        'mobile',
        'whatsapp_no',
        'aadhaar_no',
        'door_no',
        'state_id',
        'district_id',
        'area_name',
        'pincode',
        'dob',
        'is_active',
        'referral_mobile_no',
        'approval_status',
        'points',
        'otp',
        'redeem_otp',
        'otp_generated_at',
    ];

    protected $casts = [
        'otp_generated_at' => 'datetime',
    ];

    /**
     * Relationship with Dealer
     */
    public function dealer()
    {
        return $this->belongsTo(Dealers::class, 'dealer_id');
    }

    /**
     * Relationship with Executive
     */
    public function executive()
    {
        return $this->belongsTo(Executive::class, 'executive_id');
    }

    public function state()
    {
        return $this->belongsTo(States::class, 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function promotor_type()
    {
        return $this->belongsTo(PromotorType::class, 'promotor_type_id');
    }

    public function mappedDealers()
    {
        return $this->belongsToMany(Dealers::class, 'promotor_dealer_mappings', 'promotor_id', 'dealer_id');
    }
}
