<?php

namespace App\Traits;

trait TModelTranslation
{
    /**
     * alias for __("models/model_name") and __("models/model_name.fields.field_name")
     *
     * @param string               $key
     * @param array                $replace
     * @param string|null          $locale
     * @param string|\Closure|null $default
     *
     * @return array|string|null
     */
    public static function trans($key = null, $replace = [], $locale = null, $default = null)
    {
        $model_table = (snake_case(static::make()->getTable()));
        $model_name = (snake_case(class_basename(static::class)));
        $models = [
            str_plural($model_table),
            str_singular($model_table),
            $model_table,

            str_plural($model_name),
            str_singular($model_name),
            $model_name,
        ];

        $replace = !is_array($replace = value($replace)) ? array_wrap($replace) : $replace;
        $default = is_null($default = value($default)) ? $key : $default;

        $result = null;
        foreach( $models as $model ) {
            if( $result = getTrans(
                "models/{$model}.{$key}",
                getTrans(
                    "models/{$model}.fields.{$key}",
                    null,

                    $replace,
                    $locale
                ),
                $replace,
                $locale
            ) ) {
                break;
            }
        }
        $result ??= value($default);

        return $result;
    }

    /**
     * @param $key
     * @param $locale
     * @param $default
     *
     * @return array|string|null
     */
    public static function crudTrans($key = null, $locale = null, $default = null)
    {
        $model = collect(request()->route()->parameters())->first(fn($v, $n)=>is_object($v) && get_class($v)===static::class);
        if( is_array($key) ) {
            [$key, $model] = $key;
        }

        return crudTrans(static::class, $key, $locale, $default, $model);
    }
}
