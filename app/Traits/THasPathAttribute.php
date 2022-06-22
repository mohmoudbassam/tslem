<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait THasPathAttribute
{
    public static function getDiskName($disk = null)
    {
        return static::$DISK ?? (value($disk ?? '') ?: 'public');
    }

    public static function disk($disk = null)
    {
        return Storage::disk($disk??static::getDiskName($disk));
    }

    public function addPathAttribute($attribute, $file, bool $save = false)
    {
        if( $full_path = $file->store('', [ 'disk' => static::$DISK ]) ) {
            $this->$attribute = $full_path;

            if( $this->isFillable("{$attribute}_label") ) {
                $this->{"{$attribute}_label"} = $file->getClientOriginalName();
            }

            if( $save ) {
                $this->save();
            }
        }

        return $this;
    }

    public function deletePathAttribute($attribute, bool $save = false)
    {
        $storage = static::disk();
        if( $storage->exists($this->$attribute) ) {
            $storage->delete($this->$attribute);
        }

        $this->$attribute = null;

        if( $this->isFillable("{$attribute}_label") ) {
            $this->{"{$attribute}_label"} = null;
        }

        if( $save ) {
            $this->save();

            return $this->refresh();
        }

        return $this;
    }

    public function getPathUrlAttribute($attribute)
    {
        return $this->$attribute ? static::disk()->url($this->$attribute) : "";
    }

    public function setPathAttribute($attribute, $value)
    {
        if(
            $value &&
            (
                is_subclass_of($value, UploadedFile::class) ||
                is_a($value, UploadedFile::class)
            )
        ) {
            $this->addPathAttribute($attribute, $value);
        } else {
            $this->attributes[ $attribute ] = $value;
        }
    }

    public function getPathLabelAttribute($attribute)
    {
        return $this->{str_finish($attribute, "_label")};
    }
}
