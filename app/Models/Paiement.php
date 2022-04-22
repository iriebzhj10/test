<?php

namespace App\Models;

use App\Models\User;
use App\Models\Facture;
use App\Models\Parametre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Paiement extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity, HasFactory;
    protected static $logFillable = true;
    protected $fillable = [
        'libelle',
        'description',
        'montant',
        'mode_paiement_id',
        'client_id',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at',
    ];

    // public function parametre()
    // {
    //     return $this->belongsTo(Parametre::class, 'client_id', 'mode_paiement_id');
    // }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'paiements',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'NO',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function client()
    {
        return $this->belongsTo(Parametre::class);
    }

    public function mode_paiement()
    {
        return $this->belongsTo(Parametre::class);
    }

    public function factures()
    {
        return $this->belongsToMany(Facture::class)->withTimestamps();
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
