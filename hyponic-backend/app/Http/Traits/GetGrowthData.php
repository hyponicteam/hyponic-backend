<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait GetGrowthData
{
    private function getGrowthPerDays($data, $column_name)
    {
        $growth_per_days = [];

        for ($i = 0; $i < count($data) - 1; $i++) {
            $growth = round($data[$i]->{$column_name} - $data[$i + 1]->{$column_name}, 2);
            $duration = round(Carbon::parse($data[$i]->updated_at)->diffInSeconds(Carbon::parse($data[$i + 1]->updated_at), true) / 86400, 2);
            $plant_height_growth = round($growth / $duration, 2);

            array_push($growth_per_days, [
                'from' => Carbon::parse($data[$i + 1]->updated_at)->toDateTimeString(),
                'to' => Carbon::parse($data[$i]->updated_at)->toDateTimeString(),
                'growth_per_day' => $plant_height_growth,
                'unit' => 'cm/day'
            ]);
        }

        return $growth_per_days;
    }
}
