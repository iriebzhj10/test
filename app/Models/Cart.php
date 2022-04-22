<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Cart extends Model implements HasMedia
    {
        use InteractsWithMedia, SoftDeletes, LogsActivity;

        protected static $logFillable = true;

        protected $fillable = [
            'libelle',
            'description',
            'montant',
            'date_debut',
            'date_buttoire',
            'created_user',
            'updated_user',
            'status',
            'entreprise_id',
            'created_at',
            'updated_at'
        ];
}
