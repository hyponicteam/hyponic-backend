<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait TimeFormat
{
    protected function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->setTimezone('Asia/Jakarta')->toDateTimeString();
    }

    protected function getUpdatedAtAttribute($updated_at)
    {
        return Carbon::parse($updated_at)->setTimezone('Asia/Jakarta')->toDateTimeString();
    }
}
