<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CreatedUpdatedDeletedBy
{
    public static function bootCreatedUpdatedDeletedBy()
    {
        static::creating(function($model)
        {
            if(\Schema::hasColumn($model->getTable(), 'created_by'))
                $model->created_by = auth()->user()->id ?? null;

            if(\Schema::hasColumn($model->getTable(), 'updated_by'))
                $model->updated_by = auth()->user()->id ?? null;
        });

        static::updating(function($model)
        {
            if(\Schema::hasColumn($model->getTable(), 'updated_by'))
                $model->updated_by = auth()->user()->id ?? null;
        });

        static::deleting(function($model)
        {
            if(\Schema::hasColumn($model->getTable(), 'deleted_by'))
                $model->deleted_by = auth()->user()->id ?? null;
                $model->save();
        });
    }
}
