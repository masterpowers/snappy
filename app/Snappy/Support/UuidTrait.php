<?php namespace Snappy\Support;

use Rhumsaa\Uuid\Uuid;

trait UuidTrait
{
    /**
     * The "booting" method of the model.
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // Automatically assign a uuid when new models are created. This
        // prevents people from guessing what 
        static::creating(function($model)
        {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4();
        });
    }
}