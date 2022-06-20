<?php

namespace App\Models;

use App\Helpers\Calendar;
use App\Traits\TModelTranslation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class License extends Model
{
    use HasFactory;
    use TModelTranslation;

    public static $RULES = [
        // 'order_id'          => [
        //     'required',
        // ],
        'box_raft_company_box_id' => [
            'required',
        ],
        'camp_raft_company_box_id' => [
            'required',
        ],
        // 'date' => [
        //     'required',
        // ],
        'expiry_date' => [
            'required',
        ],
        'tents_count' => [
            'required',
            'numeric',
        ],
        'person_count' => [
            'required',
            'numeric',
        ],
        'camp_space' => [
            'required',
            'numeric',
        ],
        'map_path' => [
            'nullable',
            'file',
        ],
    ];

    public static $ORDER_APPROVED_RULES = [
        'expiry_date' => [
            'required',
        ],
        'tents_count' => [
            'required',
            'numeric',
        ],
        'person_count' => [
            'required',
            'numeric',
        ],
        'camp_space' => [
            'required',
            'numeric',
        ],
        'map_path' => [
            'nullable',
            'file',
        ],
    ];

    /**
     * @var mixed
     */
    protected static $LIST_COLUMNS = [
        'id',
        'order_id',
        'raft_company',
        'date',
        'expiry_date',
        'raft_company',
        'box_raft_company_box_id',
        'camp_raft_company_box_id',
    ];

    /**
     * @var string
     */
    public static $DISK = 'order_licenses';

    protected $fillable = [
        'order_id',
        'box_raft_company_box_id',
        'camp_raft_company_box_id',
        'date',
        'expiry_date',
        'tents_count',
        'person_count',
        'camp_space',
        'map_path',
        // 'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'expiry_date' => 'date',
        'order_id' => 'integer',
        'box_raft_company_box_id' => 'integer',
        'camp_raft_company_box_id' => 'integer',
        'tents_count' => 'integer',
        'person_count' => 'integer',
        'camp_space' => 'double',
        'map_path' => 'string',
    ];

    protected $dates = [
        'date',
        'expiry_date',
    ];

    protected $dateFormat = "Y/m/d H:i:s";

    // region: datatable
    public static function getIndexColumns($with_extras = false)
    {
        $results = collect(\App\Models\License::trans('fields'))
            ->reject(fn($v, $k) => !in_array($k, static::$LIST_COLUMNS))
            ->all();

        if( $with_extras ) {
            foreach( __('general.datatable.fields') as $field ) {
                $results[] = $field;
            }
        }

        return $results;
    }

    public static function getDatatableColumns($as_json = false, $with_extras = false)
    {
        $makeColumn = function($name, $orderable = null, $render = null, $className = 'text-center', $data = null) {
            $result = [
                'name' => $name = value($name),
                'data' => is_null($data = value($data)) ? $name : $data,
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
        foreach( static::getIndexColumns() as $column => $label ) {
            if( in_array($column, static::$LIST_COLUMNS) ) {
                $columns[] = $makeColumn($column);
            }
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

        foreach( static::$RULES as $column => $_rules ) {
            $rules[ $column ] = [];
            if( in_array('required', $_rules) ) {
                $rules[ $column ][ 'required' ] = true;
            }
            if( in_array('nullable', $_rules) ) {
                $rules[ $column ][ 'required' ] = false;
            }
        }

        return $rules;
    }
    // endregion: datatable

    // region: relations
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

    public function designer()
    {
        return $this->hasOneThrough(User::class, Order::class, 'id', 'id', 'order_id', 'designer_id');
    }

    public function consulting_office()
    {
        return $this->hasOneThrough(User::class, Order::class, 'id', 'id', 'order_id', 'consulting_office_id');
    }

    public function contractor()
    {
        return $this->hasOneThrough(User::class, Order::class, 'id', 'id', 'order_id', 'contractor_id');
    }

    public function service_provider()
    {
        return $this->hasOneThrough(User::class, Order::class, 'id', 'id', 'order_id', 'owner_id');
    }
    // endregion: relations

    // region: scopes
    public function scopeByBoxId(Builder $builder, $id)
    {
        return $builder->whereIn('box_raft_company_box_id', (array) $id);
    }

    public function scopeByCampId(Builder $builder, $id)
    {
        return $builder->whereIn('camp_raft_company_box_id', (array) $id);
    }

    public function scopeOnlyFullyCreated(Builder $builder)
    {
        return $builder->whereNotNull('created_at');
    }

    // endregion: scopes

    // region: map_path
    public function addMapPath($file, bool $save = false)
    {
        if( $full_path = $file->store('', [ 'disk' => static::$DISK ]) ) {
            $this->map_path = $full_path;

            if( $save ) {
                $this->save();
            }
        }

        return $this;
    }

    public function deleteMapPathFile(bool $save = false)
    {
        $storage = static::disk();
        if( $storage->exists($this->map_path) ) {
            $storage->delete($this->map_path);
        }

        $this->map_path = null;
        if( $save ) {
            $this->save();

            return $this->refresh();
        }

        return $this;
    }

    public static function disk()
    {
        return Storage::disk(static::$DISK);
    }
    // endregion: map_path

    // public function getMapPathFullAttribute()
    // {
    //     return static::disk()->path($this->map_path);
    // }

    // region: attributes
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
        return optional($this->service_provider)->raft_company_name;
    }

    public function getBoxNameAttribute()
    {
        return $this->box()->value('box');
    }

    public function getCampNameAttribute()
    {
        return $this->camp()->value('camp');
    }

    public function getDesignerNameAttribute()
    {
        return $this->designer()->value('name');
    }

    public function getDesignerCompanyNameAttribute()
    {
        return $this->designer()->value('company_name');
    }
    public function getConsultingOfficeNameAttribute()
    {
        return $this->consulting_office()->value('name');
    }

    public function getConsultingOfficeCompanyNameAttribute()
    {
        return $this->consulting_office()->value('company_name');
    }
    public function getContractorNameAttribute()
    {
        return $this->contractor()->value('name');
    }

    public function getContractorCompanyNameAttribute()
    {
        return $this->contractor()->value('company_name');
    }
    public function getWasteContractorNameAttribute()
    {
        return $this->order()->value('waste_contractor');
    }

    public function getIdLabelAttribute()
    {
        return $this->order_id;
    }

    public function getMapPathUrlAttribute()
    {
        return $this->map_path ? static::disk()->url($this->map_path) : "";
    }

    public function setMapPathAttribute($value)
    {
        if(
            $value &&
            (
                is_subclass_of($value, UploadedFile::class) ||
                is_a($value, UploadedFile::class)
            )
        ) {
            $this->addMapPath($value);
        } else {
            $this->attributes[ 'map_path' ] = $value;
        }
    }

    // endregion: attributes

    public function isFullyCreated(): bool
    {
        return !is_null($this->created_at);
    }

    /**
     * @return void|\Illuminate\Support\HtmlString|string
     */
    public function getQRElement()
    {
        $data = "";
        if( $raft = $this->service_provider->getRaftCompanyBox() ) {

            return QrCode::generate(route('qr_download_files',['raft_company_box_id'=>$raft->id]));
        }

       return false;
    }
}
