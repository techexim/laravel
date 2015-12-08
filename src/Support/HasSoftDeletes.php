<?php namespace TechExim\Support;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;

trait HasSoftDeletes
{
    use SoftDeletes;

    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootSoftDeletes()
    {
        if (static::$useSoftDeletes) {
            static::addGlobalScope(new SoftDeletingScope);
        }
    }
}