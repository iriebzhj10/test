<?php

namespace App\Models;

use Laravel\Jetstream\Membership as JetstreamMembership;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Membership extends JetstreamMembership  implements HasMedia
{
    use InteractsWithMedia, LogsActivity;
    protected static $logFillable = true;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
        ->width(368)
        ->height(232)
        ->sharpen(10);

        $this->addMediaConversion('normal')
        ->width(800)
        ->height(600)
        ->sharpen(10);

        $this
        ->addMediaConversion('my-conversion')
        ->greyscale()
        ->quality(80)
        ->withResponsiveImages();
    }
}
