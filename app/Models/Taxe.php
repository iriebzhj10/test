<?php

namespace App\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Taxe extends Model implements HasMedia
{
    use InteractsWithMedia,SoftDeletes,LogsActivity,HasFactory;
    protected static $logFillable = true;

    protected $fillable = [
        'libelle',
        'valeur',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at',
        'entreprise_id',
        'delete_update_at',
    ];
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'taxes',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'TX',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function factures()
    {
        return $this->belongsToMany(Taxe::class)->withTimestamps();
    }

    public function created_user()
    {
        return $this->belongsTo(User::class,'user_created');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
