<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Appointment extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use SoftDeletes;

    /** @var string Media library collection name */
    const MEDIA_COLLECTION_NAME = 'default';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'raft_company_box_id',
        'raft_company_location_id',
        'support_id',
        'start_at',
        'is_published',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_at'     => 'datetime',
        'is_published' => 'bool',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'raft_company_box_id'      => null,
        'raft_company_location_id' => null,
        'support_id'               => null,
        'start_at'                 => null,
        'notes'                    => null,
        'is_published'             => !1,
    ];

    /**
     * @return array[[\Illuminate\Database\Eloquent\Collection,'Illuminate\Database\Eloquent\Collection]]
     */
    public static function getCampsOfCreate(): array
    {
        $camps = RaftCompanyBox::query()->where('seen_notes', !0)->get();
        $boxes = $camps->unique('box')->sortBy('id')->values();
        return [$boxes, $camps];
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(static::MEDIA_COLLECTION_NAME)->singleFile();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function raftCompanyLocation(): BelongsTo
    {
        return $this->belongsTo(RaftCompanyLocation::class)->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function raftCompanyBox(): BelongsTo
    {
        return $this->belongsTo(RaftCompanyBox::class)->withDefault();

    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', !0);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotPublished(Builder $query): Builder
    {
        return $query->where('is_published', !1);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param $location
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByLocation(Builder $query, $location): Builder
    {
        return $query->whereIn('raft_company_location_id', (array) $location);
    }

    /**
     * $this->start_at_to_string
     *
     * @return string
     */
    public function getStartAtToStringAttribute(): string
    {
        return $this->start_at ? date_by_locale($this->start_at->format('Y-m-d g:i a')) : '';
    }

    /**
     * $this->service_provider_name
     * $this->serviceProviderName
     *
     * @return string
     */
    public function getServiceProviderNameAttribute(): string
    {
        return ($s = $this->getServiceProvider()) ? $s->company_name : '';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getServiceProvider()
    {
        $raftCompanyBox = $this->raftCompanyBox;
        $box = $raftCompanyBox->box;
        $camp = $raftCompanyBox->camp;

        if (!($user = static::serviceProviderByBoxes($box, $camp)->first())) {
            //d($raftCompanyBox);
            if (($license = License::query()->where('box_raft_company_box_id', $this->raft_company_box_id)->first()) && $license->box) {
                $box = $license->box->box;
                $camp = $license->box->camp;
                $user = static::serviceProviderByBoxes($box, $camp)->first();
            }
        }
        return $user;
    }

    /**
     * @param $box
     * @param $camp
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function serviceProviderByBoxes($box, $camp): Builder
    {
        return User::query()
            ->where('type', User::SERVICE_PROVIDER_TYPE)
            ->where('box_number', 'LIKE', $box)
            ->where('camp_number', 'LIKE', $camp);
    }

    /**
     * @return string
     */
    public function getFirstFileUrl(): string
    {
        $media = $this->getFirstMedia(static::MEDIA_COLLECTION_NAME);
        return $media ? $media->getFullUrl() : '';
    }

    /**
     * @param  int  $length
     * @param  bool  $hashTag
     * @param  null  $value
     *
     * @return string
     */
    public function getIdString(int $length = 4, bool $hashTag = !0, $value = null): string
    {
        $value = is_null($value) ? $this->getKey() : $value;
        $id = str_pad($value, $length, '0', STR_PAD_LEFT);
        return ($hashTag ? '#' : '').$id;
    }
}
