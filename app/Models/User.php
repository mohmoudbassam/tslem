<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

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

        if( $file ) {

            return asset('storage/' . $file);
        } else {
            return asset('storage/profiles/profile_placeholder.jpg');
        }
    }

    public function setPasswordAttribute($password)
    {

        $this->attributes[ 'password' ] = bcrypt($password);

    }

    public function designer_types()
    {
        return $this->hasMany(DesignerType::class);
    }

    public function contractor_types()
    {
        return $this->hasMany(ContractorSpecialtiesPivot::class);
    }

    public function getUserTypeAttribute()
    {

        return [
                   'admin' => 'مدير النظام',
                   'service_provider' => 'شركات حجاج الداخل',
                   'design_office' => 'مكتب هندسي',
                   'Sharer' => 'جهة مشاركة',
                   'consulting_office' => 'مشرف',
                   'contractor' => 'مقاول',
                   'Delivery' => 'تسليم',
                   'Kdana' => 'كدانة',
                   'raft_company' => "raft_company",
                   'taslem_maintenance' => 'تسليم صيانه',

               ][ $this->type ];
    }

    /////filters
    public function scopeWhereVitrified($q)
    {
        return $q->where('verified', 1);
    }

    /////////////////////localization
    public function getCoTypeAttribute()
    {
        if( $this->company_type ) {
            return [
                       'organization' => 'مؤسسة',
                       'office' => 'مكتب',
                   ][ $this->company_type ];
        }

        return null;

    }

    public function getVerifiedStatusAttribute()
    {
        if( $this->verified == 0 ) {
            return 'غير معتمد';
        } elseif( $this->verified == 1 ) {
            return 'تم الإعتماد';
        } elseif( $this->verified == 2 ) {
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

    public function scopeOnlyRaftCompanies($query)
    {
        return $query->where('type', 'raft_company');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'owner_id')->where('type', 'service_provider');
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
        return $this->hasMany(Order::class, 'contractor_id')->where('type', 'contractor');
    }

    public function main_route()
    {
        if( $this->type == 'admin' ) {
            return route('dashboard');
        }

        if( $this->type == 'service_provider' ) {
            return route('services_providers.orders');
        }

        if( $this->type == 'Delivery' ) {
            return route('delivery');
        }

        if( $this->type == 'design_office' ) {
            return route('design_office.orders');
        }

        if( $this->type == 'design_office' ) {
            return route('design_office.orders');
        }
        if( $this->type == 'contractor' ) {
            return route('contractor.orders');
        }

        if( $this->type == 'Sharer' ) {
            return route('Sharer.order');
        }
        if( $this->type == 'raft_company' ) {

            return route('raft_company');
        }
        if( $this->type == 'taslem_maintenance' ) {
            return route('taslem_maintenance.index');
        }
        if( $this->type == 'raft_center' ) {
            return route('raft_center');
        }

    }

    public function updatePassword($password, $save = false)
    {
        $this->password = $password;
        if( $save ) {
            $this->save();

            return $this->refresh();
        }

        return $this;
    }

    public function getRaftCompanyBox($default = null)
    {
        $user = $this;
        $where = ($license_number = $user->license_number) ?
            compact('license_number') : [
                'box' => $user->box_number,
                'camp' => $user->camp_number,
            ];

        return \App\Models\RaftCompanyBox::where($where)->first() ?? value($default);
    }

    public function hasRaftCompanyBox(): bool
    {
        $user = $this;
        $where = ($license_number = $user->license_number) ?
            compact('license_number') : [
                'box' => $user->box_number,
                'camp' => $user->camp_number,
            ];

        return \App\Models\RaftCompanyBox::where($where)->count();
    }
}
