<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ADMIN_TYPE = 'admin';
    public const SERVICE_PROVIDER_TYPE = 'service_provider';
    public const DESIGN_OFFICE_TYPE = 'design_office';
    public const SHARER_TYPE = 'Sharer';
    public const CONSULTNG_OFFICE_TYPE = 'consulting_office';
    public const CONTRACTOR_TYPE = 'contractor';
    public const DELIVERY_TYPE = 'Delivery';
    public const KDANA_TYPE = 'Kdana';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->type == 'admin';
    }

    public function getImageAttribute($file)
    {

        if ($file) {

            return asset('storage/' . $file);
        } else {
            return asset('storage/profiles/profile_placeholder.jpg');
        }
    }

    public function setPasswordAttribute($password)
    {

        $this->attributes['password'] = bcrypt($password);

    }

    public function getUserTypeAttribute()
    {

        return [
            'admin' => 'مدير النظام',
            'service_provider' => 'مقدم خدمة',
            'design_office' => 'مكتب تصميم',
            'Sharer' => 'جهة مشاركة',
            'consulting_office' => 'مكتب استشاري',
            'contractor' => 'مقاول',
            'Delivery' => 'تسليم',
            'Kdana' => 'كدانة',
        ][$this->type];
    }


    /////filters
    public function scopeWhereVitrified($q)
    {
        return $q->where('verified', 1);
    }


    /////////////////////localization
    public function getCoTypeAttribute()
    {
        if ($this->company_type) {
            return [
                'organization' => 'مؤسسة',
                'office' => 'مكتب',
            ][$this->company_type];
        }
        return null;

    }

    public function getVerifiedStatusAttribute()
    {
        if ($this->verified == 0) {
            return 'غير معتمد';
        } elseif ($this->verified == 1) {
            return 'تم الإعتماد';
        } elseif ($this->verified == 2) {
            return 'تم الرفض';
        }
        return null;

    }

    public function designer_order_rejected()
    {
        return $this->belongsTo(DesignerRejected::class, 'id', 'designer_id')
            ->where('type', 'design_office');
    }

    public function scopeWhereDesigner($query)
    {
        return $query->where('type', 'design_office');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'owner_id');
    }
    public function designer_orders()
    {
        return $this->hasMany(Order::class, 'designer_id')->where('type', 'design_office');
    }
    public function consulting_orders()
    {
        return $this->hasMany(Order::class, 'consulting_office_id')->where('type', 'consulting_office');
    }
    public function contractors_orders()
    {
        return $this->hasMany(Order::class, 'consulting_office_id')->where('type', 'contractors_orders');
    }

}
