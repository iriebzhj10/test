<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserInfo extends  Model implements HasMedia
{
    use  InteractsWithMedia, SoftDeletes, LogsActivity;
    protected static $logFillable = true;
    protected $fillable = [

            'libelle',
            'contact',
            'type_piece',
            'numero_piece',
            'email',
            'description',
            'user_id',
            'type_user_id',
            'created_user',
            'updated_user',
            'status',
            'created_at',
            'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'user_infos',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'UI',
                'reset_on_prefix_change' => false,
            ]);
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type_user()
    {
        return $this->belongsTo(Parametre::class);
    }
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
