<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait THasPathAttribute
{
    /**
     * @param string|\Closure|null $disk
     *
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public static function disk($disk = null): \Illuminate\Contracts\Filesystem\Filesystem
    {
        return Storage::disk(value($disk) ?: static::getDiskName($disk));
    }

    /**
     * @param string|\Closure|null $filename
     * @param string|\Closure|null $disk
     *
     * @return string
     */
    public static function diskPath($filename = null, $disk = null): string
    {
        return static::disk($disk)->path(value($filename));
    }

    /**
     * @param string|\Closure|null $disk
     *
     * @return string
     */
    public static function getDiskName($disk = null): string
    {
        return (string) ((static::$DISK ?? value($disk ?? '')) ?: 'public');
    }

    /**
     * @return string
     */
    public static function getFileLabelSuffix(): string
    {
        return static::hasFileLabel() ? (static::$FILE_LABEL_SUFFIX ?? '') : '';
    }

    public static function hasFileLabel(): bool
    {
        return (bool) (static::$FILE_LABEL_SUFFIX ?? '');
    }

    /**
     * @param string|\Closure $attribute
     *
     * @return string
     */
    public function getFileLabelAttributeName($attribute): string
    {
        return static::hasFileLabel() ? str_finish($attribute, static::getFileLabelSuffix()) : $attribute;
    }

    /**
     * @param string|\Closure|null $attribute
     *
     * @return mixed
     */
    public function getPathLabelAttributeValue($attribute)
    {
        $attribute = $this->getFileLabelAttributeName($attribute);

        return $this->$attribute;
    }

    /**
     * @param      $attribute
     * @param      $file
     * @param bool $save
     *
     * @return \Illuminate\Database\Eloquent\Model|self
     */
    public function addPathAttribute($attribute, $file, bool $save = false): self
    {
        if( $full_path = $file->store('', [ 'disk' => static::$DISK ]) ) {
            $this->$attribute = $full_path;

            if( static::hasFileLabel() && $this->isFillable("{$attribute}_label") ) {
                $this->{"{$attribute}_label"} = $file->getClientOriginalName();
            }

            if( $save ) {
                $this->save();
            }
        }

        return $this;
    }

    /**
     * @param      $attribute
     * @param bool $save
     *
     * @return \Illuminate\Database\Eloquent\Model|self
     */
    public function deletePathAttribute($attribute, bool $save = false): self
    {
        $storage = static::disk();
        if( $storage->exists($this->$attribute) ) {
            $storage->delete($this->$attribute);
        }

        $this->$attribute = null;

        if( static::hasFileLabel() && $this->isFillable("{$attribute}_label") ) {
            $this->{"{$attribute}_label"} = null;
        }

        if( $save ) {
            $this->save();

            return $this->refresh();
        }

        return $this;
    }

    /**
     * @param string|\Closure $attribute
     *
     * @return string
     */
    public function getPathUrlAttributeValue($attribute): string
    {
        $attribute = value($attribute);

        return $this->$attribute ? static::disk()->url($this->$attribute) : "";
    }

    /**
     * @param string|\Closure                           $attribute
     * @param \Illuminate\Http\UploadedFile|string|null $value
     *
     * @return \Illuminate\Database\Eloquent\Model|self
     */
    public function setPathAttributeValue($attribute, $value): self
    {
        $attribute = value($attribute);
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

        return $this;
    }
}
