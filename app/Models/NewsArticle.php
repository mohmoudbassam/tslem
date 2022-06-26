<?php

namespace App\Models;

use App\Traits\TModelTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class CarPart
 *
 * @package App\Models
 */
class NewsArticle extends Model
{
    use HasFactory;
    use TModelTranslation;

    /**
     * @var \string[][]
     */
    public static $RULES = [
        'title' => ['required'],
        'image' => ['array'],
        // 'image.*' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:5000'],
        'body' => ['required'],
        'is_published' => ['nullable'],
        'user_id' => ['nullable'],
    ];
    /**
     * @var string
     */
    public static $DISK = 'news_articles';
    /**
     * @var mixed
     */
    public static $LIST_COLUMNS = [
        'id',
        'title',
        'user_id',
        'created_at',
        'is_published',
    ];
    /**
     * @var mixed
     */
    protected static $LIST_COLUMNS_ORDERABLE = [
        'id',
        'title',
        'user_id',
        'created_at',
        'is_published',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'body',
        'is_published',
        'sort_order',
        'user_id',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'title' => 'string',
        'body' => 'string',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * @param $with_extras
     *
     * @return array
     */
    public static function getIndexColumns($with_extras = false)
    {
        $results = collect(\App\Models\NewsArticle::trans('fields'))
            ->reject(fn ($v, $k) => !in_array($k, static::$LIST_COLUMNS))
            ->all();
        if ($with_extras) {
            foreach (__('general.datatable.fields') as $field) {
                $results[] = $field;
            }
        }

        return $results;
    }

    /**
     * @param $as_json
     * @param $with_extras
     *
     * @return array|false|string
     */
    public static function getDatatableColumns($as_json = false, $with_extras = false)
    {
        $makeColumn = function ($name, $orderable = null, $render = null, $className = 'text-center', $data = null) {
            $result = [
                'name' => $name = value($name),
                'data' =>  is_null($data = value($data)) ? $name : $data,
                'className' => $className = value($className),
                'orderable' => value($orderable) ?? false //ends_with($name, '_id'),
            ];
            if (!is_null($render)) {
                $result['render'] = $render;
            }

            return $result;
        };
        $columns = [];
        foreach (static::getIndexColumns() as $column => $label) {
            $orderable = in_array($column, static::$LIST_COLUMNS_ORDERABLE);
            $columns[] = $makeColumn($column, $orderable);
        }
        if ($with_extras) {
            foreach (__('general.datatable.fields') as $field => $label) {
                $orderable = in_array($field, static::$LIST_COLUMNS_ORDERABLE);
                $columns[] = $makeColumn($field, $orderable);
            }
        }

        return $as_json ? json_encode($columns) : $columns;
    }

    /**
     * @param $column
     *
     * @return array
     */
    public static function optionsFor($column)
    {
        $column = value($column);
        if ($column === 'is_published') {
            return [0 => trans('general.no'), 1 => trans('general.yes')];
        }

        return [];
    }

    /**
     * @return array
     */
    public static function getRules()
    {
        $rules = [];
        foreach (static::$RULES as $column => $_rules) {
            $rules[$column] = [];
            if (in_array('required', $_rules)) {
                $rules[$column]['required'] = true;
            }
            if (in_array('nullable', $_rules)) {
                $rules[$column]['required'] = false;
            }
        }

        return $rules;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param      $file
     * @param bool $save
     *
     * @return string
     */
    public function addImagePath($file, bool $save = false)
    {
        if ($full_path = $file->store('', ['disk' => static::$DISK])) {
            return $full_path ? static::disk()->url($full_path) : "";
        }

        return $this;
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public static function disk($disk = null)
    {
        return Storage::disk($disk ?? static::$DISK);
    }

    /**
     * @return mixed
     */
    public function getUserNameAttribute()
    {
        return $this->user()->value('name');
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->is_published;
    }

    /**
     * @param bool $save
     *
     * @return $this
     */
    public function togglePublish(bool $save = false)
    {
        $this->is_published = !$this->isPublished();
        if ($save) {
            $this->save();
            $this->refresh();
        }

        return $this;
    }

    public function files()
    {
        return $this->hasMany(File::class, 'item_id')->where('type', 'news');
    }
}
