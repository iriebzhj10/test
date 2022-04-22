<?php

namespace App\Models;

use App\Models\User;
use App\Models\Parametre;
use App\Models\Entreprise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Prevision extends Model implements HasMedia
{
    use InteractsWithMedia,SoftDeletes,LogsActivity;
    protected static $logFillable = true;
    protected $fillable = [
        'libelle',
        'description',
        'budget',
        'date_debut',
        'date_fin',
        'entreprise_id',
        'type_prevision_id',
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
                'table' => 'previsions',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'PRV',
                'reset_on_prefix_change' => false,
            ]);
        });
    }
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function parametre()
    {
        return $this->belongsTo(Parametre::class, 'type_prevision_id');
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
