<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class SiteEntry extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'promotor_type_id',
        'site_id',
        'site_name',
        'executive_id',
        'dealer_id',
        'brand_id',
        'visit_date',
        'img',
        'lat',
        'long',
        'pincode',
        'state',
        'district',
        'area',
        'door_no',
        'street_name',
        'building_stage',
        'floor_stage',
        'contact_no',
        'contact_person',
        'requirement_qty',
    ];

    public function promotorType()
    {
        return $this->belongsTo(PromotorType::class, 'promotor_type_id');
    }

    public function promotor()
    {
        return $this->belongsTo(Promotor::class, 'promotor_id');
    }

    public function executive()
    {
        return $this->belongsTo(Executive::class, 'executive_id');
    }

    public function dealer()
    {
        return $this->belongsTo(Dealers::class, 'dealer_id');
    }

    public function state()
    {
        return $this->belongsTo(States::class, 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function pincode()
    {
        return $this->belongsTo(Pincode::class, 'pincode_id');
    }
}
