<?php

namespace App\Models;

use App\Models\User;
use App\Models\Parametre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Commande extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity , HasFactory;
    protected static $logFillable = true;
    /**
     * Get the user that owns the Commande
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    protected $fillable = [
        'libelle',
        'description',
        'client_id',
        'fournisseur_id',
        'montant',
        'taxe',
        'remise',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at'
    ];

    // public function parametre()
    // {
    //     return $this->belongsTo(Parametre::class, 'client_id', 'fournisseur_id');
    // }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'commandes',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'CO',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function client()
    {
        return $this->belongsTo(Parametre::class);
    }

    public function fournisseur()
    {
        return $this->belongsTo(Parametre::class);
    }

    public function created_user()
    {
        return $this->belongsTo(User::class ,'user_created');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class ,'user_updated');
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
