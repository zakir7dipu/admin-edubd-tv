<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

trait CreatedByUpdatedBy
{
    public static function boot()
    {
        parent::boot();

        if (!App::runningInConsole()) {

            static::creating(function ($model) {
                $data = [];

                if (Schema::hasColumn($model->getTable(), 'created_by')) {
                    $data['created_by'] = auth()->id();
                }

                if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                    $data['updated_by'] = auth()->id();
                }

                if (count($data) > 0) {
                    $model->fill($data);
                }
            });

            static::updating(function ($model) {
                if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                    $model->fill(['updated_by' => auth()->id()]);
                }
            });
        }
    }
}