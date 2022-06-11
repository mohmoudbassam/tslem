<?php

if( !function_exists('isModel') ) {
    /**
     * Determine if a given object is inherit Model class.
     *
     * @param \Illuminate\Database\Eloquent\Model|object $object
     *
     * @return bool
     */
    function isModel($object): bool
    {
        try {
            return ($object instanceof \Illuminate\Database\Eloquent\Model)
                   || is_a($object, \Illuminate\Database\Eloquent\Model::class)
                   || is_subclass_of($object, \Illuminate\Database\Eloquent\Model::class);
        } catch(Exception $exception) {

        }

        return false;
    }
}

if( !function_exists('isDateAttribute') ) {
    /**
     * @param $model
     * @param $key
     *
     * @return bool
     */
    function isDateAttribute($model, $key): bool
    {
        try {
            $model = is_object($model) ? $model : app($model);
            return in_array($key, $model->getDates(), true) ||
                   $model->hasCast($key, ['date', 'datetime', 'immutable_date', 'immutable_datetime']);
        } catch(Exception $exception) {

        }

        return false;
    }
}
