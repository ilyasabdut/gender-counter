<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

abstract class BaseModel extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = ['id'];

    protected bool $usingUuid = true;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if($model->usingUuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

}
