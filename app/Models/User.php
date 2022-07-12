<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function isContractor()
    {
        return $this->type === static::CONTRACTOR_TYPE;
    }

    public function isConsultngOffice()
    {
        return $this->type === static::CONSULTNG_OFFICE_TYPE;
    }

    public function isDelivery()
    {
        return $this->type === static::DELIVERY_TYPE;
    }

    public function getImageAttribute($file)
    {

        if ($file) {

            return asset('storage/'.$file);
        }
        else {
            return asset('storage/profiles/profile_placeholder.jpg');
        }
    }

    public function setPasswordAttribute($password)
    {

        $this->attributes['password'] = bcrypt($password);

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

            'admin'              => 'مدير النظام',
            'service_provider'   => 'شركات حجاج الداخل',
            'design_office'      => 'مكتب هندسي',
            'Sharer'             => 'جهة مشاركة',
            'consulting_office'  => 'مشرف',
            'contractor'         => 'مقاول',
            'Delivery'           => 'تسليم',
            'Kdana'              => 'كدانة',
            'raft_company'       => "raft_company",
            'taslem_maintenance' => 'تسليم صيانه',

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
                'office'       => 'مكتب',
            ][$this->company_type];
        }

        return null;

    }

    public function getVerifiedStatusAttribute()
    {
        if ($this->verified == 0) {
            return 'غير معتمد';
        }
        elseif ($this->verified == 1) {
            return 'تم الإعتماد';
        }
        elseif ($this->verified == 2) {
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

        if ($this->type == 'admin') {
            return route('dashboard');
        }

        if ($this->type == 'service_provider') {
            return route('services_providers.orders');
        }

        if ($this->type == 'Delivery') {
            return route('delivery');
        }

        if ($this->type == 'design_office') {
            return route('design_office.orders');
        }

        if ($this->type == 'consulting_office') {
            return route('consulting_office');
        }
        if ($this->type == 'contractor') {
            return route('contractor.orders');
        }

        if ($this->type == 'Sharer') {
            return route('Sharer.order');
        }
        if ($this->type == 'raft_company') {

            return route('raft_company');
        }
        if ($this->type == 'taslem_maintenance') {
            return route('taslem_maintenance.index');
        }
        if ($this->type == 'raft_center') {
            return route('raft_center');
        }
        if ($this->type == 'Kdana') {
            return route('kdana');
        }
        if ($this->type == 'multi_media') {
            return route('news_articles');
        }
    }

    public function is_designer_consulting()
    {
        return $this->hasMany(DesignerType::class, 'user_id')
            ->where('type', 'consulting')->first();

    }

    public function updatePassword($password, $save = false)
    {
        $this->password = $password;
        if ($save) {
            $this->save();

            return $this->refresh();
        }

        return $this;
    }

    /**
     * $this->raft_company_name
     *
     * @return string
     */
    public function getRaftCompanyNameAttribute()
    {
        $raft_company_location_name = $this->raft_name_only;
        return "{$this->company_name} / {$raft_company_location_name}";
    }

    /**
     * $this->raft_name_only
     *
     * @return string
     */
    public function getRaftNameOnlyAttribute()
    {
        if (!$this->parent_id) {
            $raft_company_location_name = License::trans("no_parent_name");
        }
        else {
            $raft_company_location_name = License::trans('raft_company_name', [
                'name' => optional($this->raft_company_location)->name,
            ]);
        }

        return $raft_company_location_name ?: '';
    }

    public function raft_company_location()
    {
        return optional($this->getRaftCompanyBox())->raft_company_location();
    }

    public function getRaftCompanyBox($default = null)
    {
        $user = $this;
        $user = optional($user ?? currentUser());
        $where = ($license_number = $user->license_number) ?
            compact('license_number') : [
                'box'  => $user->box_number,
                'camp' => $user->camp_number,
            ];

        return RaftCompanyBox::where($where)->first() ?: value($default);
    }

    public function hasRaftCompanyBox(): bool
    {
        $user = $this;
        $where = ($license_number = $user->license_number) ?
            compact('license_number') : [
                'box'  => $user->box_number,
                'camp' => $user->camp_number,
            ];

        return RaftCompanyBox::where($where)->count();
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function raft_company()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    public function raft_company_service_providers()
    {
        return $this->hasMany(User::class, 'parent_id', 'id');
    }

    public function raft_location()
    {
        return $this->belongsTo(RaftCompanyLocation::class, 'raft_company_type', 'id');
    }

    public function hasFirstAppointmentUrl(): bool
    {
        return $this->appointment->getFirstFileUrl();
    }

    public function getFirstAppointmentUrl(): ?string
    {
        return $this->appointment->getFirstFileUrl();
        //return route('.Appointment.generatePdf', auth()->id());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function appointment(): HasOne
    {
        return $this->hasOne(Appointment::class, 'service_provider_id')->withDefault();
    }
}
