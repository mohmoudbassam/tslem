<?php

namespace App\Models;

use App\Traits\TModelTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OrderLogs extends Model
{
    use HasFactory;
    use TModelTranslation;

    public static $RULES = [
        'order_id' => [
            'required',
        ],
        'user_id' => [
            'required',
        ],
        'data' => [
            'required',
        ],
        'created_at' => [
            'required',
        ],
    ];

    /**
     * @var mixed
     */
    public static $LIST_COLUMNS = [
        'id',
        'order_id',
        'user_id',
        'data',
        'created_at',
    ];

    /**
     * @var mixed
     */
    public static $LIST_COLUMNS_ORDERABLE = [
        'id',
        'order_id',
        'user_id',
        'data',
        'created_at',
    ];

    /**
     * @var string
     */
    public static $DISK = 'public';

    protected $table = 'order_logs';

    protected $fillable = [
        'order_id',
        'user_id',
        'data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order_id' => 'integer',
        'user_id' => 'integer',
        'data' => 'string',
    ];

    protected $dates = [];

    protected $dateFormat = "Y/m/d H:i:s";

    // region: datatable
    public static function getIndexColumns($with_extras = false)
    {
        $results = collect(\App\Models\OrderLogs::trans('fields'))
            ->reject(fn($v, $k) => !in_array($k, static::$LIST_COLUMNS))
            ->all();

        // if( $with_extras ) {
        //     foreach( __('general.datatable.fields') as $field ) {
        //         $results[] = $field;
        //     }
        // }

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
        foreach( static::getIndexColumns() as $column => $label ) {
            if( in_array($column, static::$LIST_COLUMNS) ) {
                $orderable = in_array($column, static::$LIST_COLUMNS_ORDERABLE);
                $columns[] = $makeColumn($column, $orderable);
            }
        }

        // if( $with_extras ) {
        //     foreach( __('general.datatable.fields') as $field => $label ) {
        //         $orderable = in_array($column, static::$LIST_COLUMNS_ORDERABLE);
        //         $columns[] = $makeColumn($field, $orderable);
        //     }
        // }

        return $as_json ? json_encode($columns) : $columns;
    }

    public static function optionsFor($column)
    {
        $column = value($column);
        if( $column === 'order_id' ) {
            return Order::pluck('id', 'id')->toArray();
        }

        return [];
    }

    public static function getRules(?string $constant = null)
    {
        $constant = str_ireplace('$', '', $constant ?: '$RULES');
        $rules = [];
        $_rules = static::$$constant ?? static::$RULES;

        foreach( $_rules as $column => $_rules ) {
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

    public static function disk($disk = null)
    {
        return Storage::disk($disk ?? static::$DISK);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getOrderIdentifierAttribute()
    {
        return $this->order()->value('identifier');
    }

    public function scopeOrderByOrderIdentifier(Builder $builder, $dir = null)
    {
        return $builder
            ->join($orders_table = Order::make()->getTable(), $this->getTable() . ".order_id", '=', "{$orders_table}.id")
            ->orderBy("{$orders_table}.identifier", $dir ?? 'desc')
            ->select($this->getTable() . '.*');
    }

    public function scopeByOrderIdentifier(Builder $builder, $identifier)
    {
        return $builder
            ->whereHas('order', fn(Builder $query) => $query->where('identifier', $identifier));
    }
}
