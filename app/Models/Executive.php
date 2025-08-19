<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Executive extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'executives';

    protected $fillable = [
        'name',
        'role',
        'mobile',
        'address',
        'action',
        'app_password',
        'state_id',
        'district_id',
        'otp',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'dealer_ids' => 'array',
    ];

    public function states()
    {
        return $this->belongsTo(States::class, 'state_id');
    }
    public function districts()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function dealers()
    {
        return $this->belongsToMany(Dealers::class, 'id');
    }
    public function dealerMappings()
    {
        return $this->hasMany(ExecutiveDealerMapping::class, 'executive_id');
    }
}
