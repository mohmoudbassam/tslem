<?php

namespace App\Models;

use App\Helpers\Calendar;
use App\Traits\TModelTranslation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;
    use TModelTranslation;

    public static $RULES = [
        // 'order_id'          => [
        //     'required',
        // ],
        'raft_company_id'          => [
            'required',
        ],
        'box_raft_company_box_id'  => [
            'required',
        ],
        'camp_raft_company_box_id' => [
            'required',
        ],
        'date'                     => [
            'required',
        ],
        'expiry_date'              => [
            'required',
        ],
        'tents_count'              => [
            'required',
            'numeric',
        ],
        'person_count'             => [
            'required',
            'numeric',
        ],
        'camp_space'               => [
            'required',
            'numeric',
        ],
    ];
    /**
     * @var mixed
     */
    protected static $LIST_COLUMNS = [
        'id',
        'date',
        'expiry_date',
        'raft_company_id',
        'box_raft_company_box_id',
        'camp_raft_company_box_id',
    ];

    protected $fillable = [
        'order_id',
        'raft_company_id',
        'box_raft_company_box_id',
        'camp_raft_company_box_id',
        'date',
        'expiry_date',
        'tents_count',
        'person_count',
        'camp_space',
        // 'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date'                     => 'date',
        'expiry_date'              => 'date',
        'order_id'          => 'integer',
        'raft_company_id'          => 'integer',
        'box_raft_company_box_id'  => 'integer',
        'camp_raft_company_box_id' => 'integer',
        'tents_count'              => 'integer',
        'person_count'             => 'integer',
        'camp_space'               => 'double',
    ];

    protected $dates = [
        'date',
        'expiry_date',
    ];

    protected $dateFormat = "Y/m/d H:i:s";

    public static function getDatatableColumns($as_json = false, $with_extras = false)
    {
        $makeColumn = function ($name, $orderable = null, $render = null, $className = 'text-center', $data = null) {
            $result = [
                'name'      => $name = value($name),
                'data'      => is_null($data = value($data)) ? $name : $data,
                'className' => $className = value($className),
                'orderable' => value($orderable) ?? false//ends_with($name, '_id'),
            ];
            if( !is_null($render) ) {
                if( is_string($render = value($render)) && $render === 'date' ) {
                    $result[ 'render' ] = <<<CODE
function (data) { return moment( data ).format( "YYYY-MM-DD hh:mm:ss" ); }
CODE;

                } else {
                    $result[ 'render' ] = $render;
                }
            }
            return $result;
        };
        $columns = [];
        // $columns[] = $makeColumn('id', true);
        // dd(($model = static::make())->getFillable());
        foreach( ($model = static::make())->getFillable() as $column ) {
            $columns[] = $makeColumn($column);
        }

        if( $with_extras ) {
            foreach( __('general.datatable.fields') as $field => $label ) {
                $columns[] = $makeColumn($field);
            }
        }

        return $as_json ? json_encode($columns) : $columns;
    }

    public static function optionsFor($column)
    {
        $column = value($column);
        if( $column === 'raft_company_id' ) {
            return User::OnlyRaftCompanies()->pluck('name', 'id')->toArray();
        }
        if( $column === 'box_raft_company_box_id' ) {
            return RaftCompanyBox::pluck('box', 'id')->toArray();
        }
        if( $column === 'camp_raft_company_box_id' ) {
            return RaftCompanyBox::pluck('camp', 'id')->toArray();
        }
        if( $column === 'order_id' ) {
            return Order::pluck('id', 'id')->toArray();
        }

        return [];
    }

    public static function getRules()
    {
        $rules = [];
        foreach( static::$RULES as $column => $rules ) {
            $rules[ $column ] = [];
            if( in_array('required', $rules) ) {
                $rules[ $column ][ 'required' ] = true;
            }
            if( in_array('nullable', $rules) ) {
                $rules[ $column ][ 'required' ] = false;
            }
        }

        return $rules;
    }

    public static function getIndexColumns()
    {
        return collect(\App\Models\License::trans('fields'))->reject(static::$LIST_COLUMNS)->all();
    }

    public function raft_company()
    {
        return $this->belongsTo(User::class, 'raft_company_id');
    }

    public function box()
    {
        return $this->belongsTo(RaftCompanyBox::class, 'box_raft_company_box_id');
    }

    public function camp()
    {
        return $this->belongsTo(RaftCompanyBox::class, 'camp_raft_company_box_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeByRaftCompany(Builder $builder, $id)
    {
        return $builder->whereIn('raft_company_id', (array) $id);
    }

    public function scopeByBoxId(Builder $builder, $id)
    {
        return $builder->whereIn('box_raft_company_box_id', (array) $id);
    }

    public function scopeByCampId(Builder $builder, $id)
    {
        return $builder->whereIn('camp_raft_company_box_id', (array) $id);
    }

    public function getDateAttribute($value)
    {
        $value ??= data_get($this->attributes, 'date');
        $value = $value ? Carbon::parse($value) : null;
        return $value ? $value->toDateString() : null;
    }

    public function getHijriDateAttribute()
    {
        return Calendar::make(str_before($this->getDateFormat(), ' '))
                       ->hijriDate($this->date);
    }

    public function date()
    {
        $value = data_get($this->attributes, 'date');
        return $value ? Carbon::parse($value) : null;
    }

    public function getExpiryDateAttribute($value)
    {
        $value ??= data_get($this->attributes, 'expiry_date');
        $value = $value ? Carbon::parse($value) : null;
        return $value ? $value->toDateString() : null;
    }

    public function getHijriExpiryDateAttribute()
    {
        return Calendar::make(str_before($this->getDateFormat(), ' '))
                       ->hijriDate($this->expiry_date);
    }

    public function expiry_date()
    {
        $value = data_get($this->attributes, 'expiry_date');
        return $value ? Carbon::parse($value) : null;
    }

    public function getRaftCompanyNameAttribute()
    {
        return ($m = $this->raft_company) ? $m->name : null;
    }
    public function getBoxNameAttribute()
    {
        return ($m = $this->box) ? $m->box : null;
    }
    public function getCampNameAttribute()
    {
        return ($m = $this->camp) ? $m->camp : null;
    }

    public function getIdLabelAttribute()
    {
        return $this->order_id;
    }

    public function owner()
    {
        return optional($this->order)->service_provider();
    }
}
