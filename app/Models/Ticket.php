<?php

namespace App\Models;

use App\Models\User;
use App\Models\Echange;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Ticket extends Model implements HasMedia
{
    use InteractsWithMedia,SoftDeletes,LogsActivity,HasFactory;
    protected static $logFillable = true;
    use HasFactory;

    protected $fillable = [
        'libelle',
        'description',
        'user_id',
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
                'table' => 'tickets',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'TK',
                'reset_on_prefix_change' => false,
            ]);
        });
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function echanges()
    {
        return $this->hasMany(Echange::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    public function created_user()
    {
        return $this->belongsTo(User::class,'user_created');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class,'user_updated');
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
