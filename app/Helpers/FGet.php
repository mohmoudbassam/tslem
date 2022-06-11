<?php

if( !function_exists('getTrans') ) {
    /**
     * Translate the given message or return default.
     *
     * @param string|null $key
     * @param array       $replace
     * @param string|null $locale
     *
     * @return string|array|null
     */
    function getTrans($key = null, $default = null, $replace = [], $locale = null)
    {
        $key = value($key);
        $return = __($key, $replace, $locale);

        return $return === $key ? value($default) : $return;
    }
}

if( !function_exists('currentLocale') ) {
    /**
     * return appLocale
     *
     * @param bool $full
     *
     * @return string
     */
    function currentLocale($full = false): string
    {
        if( $full ) {
            return (string) app()->getLocale();
        }

        $locale = str_replace('_', '-', app()->getLocale());
        $locale = current(explode("-", $locale));

        return $locale ?: "";
    }
}

if( !function_exists('crudTrans') ) {
    /**
     * @param \Illuminate\Database\Eloquent\Model|string|\Closure $model
     * @param \Closure|string|null                                $key
     * @param \Closure|string|null                                $locale
     * @param \Closure|mixed|null                                 $default
     *
     * @return array|string|null
     */
    function crudTrans($model = null, $key = null, $locale = null, $default = null, $instance = null)
    {
        $locale ??= currentLocale();
        $getModelTrans =
            fn($is_singular = true) => isModel($model) ? $model::trans(
                $is_singular ? 'singular' : 'plural',
                [],
                $locale
            )
                : ($is_singular ? 'str_singular' : 'str_plural')($model);
        $_instance = $instance;
        $instance = $instance && isModel($instance) ? $instance : optional((object)[ 'id' => $instance ?? '' ]);
//        dump($instance->id,$instance,$_instance);
        $results = __('general.model', [
            'prefix' => $instance->id ? $getModelTrans(true) . ' ' : '',
            'model'  => $instance->id ?: $getModelTrans(true),
            'models' => $getModelTrans(false),
        ],            $locale);

        $key = value($key);
        return is_null($key) ? $results : data_get($results, $key, $default);
    }
}
