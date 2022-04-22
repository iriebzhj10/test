<?php

namespace App\Models;

use App\Models\User;
use App\Models\Projet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Activite extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity;
    protected static $logFillable = true;
   /**
    * Get the projet that owns the Activite
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    protected $fillable = [
        'libelle',
        'description',
        'projet_id',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'activites',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'AC',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function created_user()
    {
        return $this->belongsTo(User::class, 'user_created');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class, 'user_updated');
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
