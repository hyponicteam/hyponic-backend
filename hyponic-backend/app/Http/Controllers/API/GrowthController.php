<?php

namespace App\Http\Controllers\API;

use App\Growth;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Traits\GetGrowthData;
use Illuminate\Http\Request;

class GrowthController extends Controller
{
    use GetGrowthData;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'plant_height' => 'numeric|between:0,99.99',
            'leaf_width' => 'numeric|between:0,99.99',
            'temperature' => 'numeric|between:0,99.99',
            'acidity' => 'numeric|between:0,99.99',
            'plant_id' => 'string|required'
        ]);

        if (!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input',
                400
            );
        }

        $growth = Growth::create([
            'plant_height' => $fields['plant_height'],
            'leaf_width' => $fields['leaf_width'],
            'temperature' => $fields['temperature'],
            'acidity' => $fields['acidity'],
            'plant_id' => $fields['plant_id'],
        ]);

        return ResponseFormatter::success(
            $growth,
            'New data created'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Growth $growth)
    {
        return ResponseFormatter::success(
            $growth,
            'Success get growth data'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Growth $growth)
    {
        if ($request->input('plant_height')) {
            $fields = $request->validate([
                'plant_height' => 'numeric|between:0,99.99'
            ]);
            $growth->update([
                'plant_height' => $fields['plant_height']
            ]);
        }

        if ($request->input('leaf_width')) {
            $fields = $request->validate([
                'leaf_width' => 'numeric|between:0,99.99'
            ]);
            $growth->update([
                'leaf_width' => $fields['leaf_width']
            ]);
        }

        if ($request->input('temperature')) {
            $fields = $request->validate([
                'temperature' => 'numeric|between:0,99.99'
            ]);
            $growth->update([
                'temperature' => $fields['temperature']
            ]);
        }

        if ($request->input('acidity')) {
            $fields = $request->validate([
                'acidity' => 'numeric|between:0,99.99'
            ]);
            $growth->update([
                'acidity' => $fields['acidity']
            ]);
        }

        return ResponseFormatter::success(
            $growth,
            'Growth data updated'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Growth $growth)
    {
        $growth->delete();

        return ResponseFormatter::success(
            null,
            'Growth data deleted'
        );
    }

    public function top(Request $request)
    {
        if ($request->input('category')) {
            $fields = $request->validate([
                'category' => 'string|required',
                'n' => 'numeric|required|min:1|max:10',
                'plant_id' => 'string|required'
            ]);

            if (!$fields) {
                return ResponseFormatter::error(
                    null,
                    'Invalid input',
                    400
                );
            }

            if ($fields['category'] == 'plant_height' || $fields['category'] == 'leaf_width') {
                $growths_data = Growth::where('plant_id', $fields['plant_id'])->orderBy('updated_at', 'desc')->get();

                if(count($growths_data) > 1) {
                    $growth_per_days = [];
    
                    $growth_per_days = $this->getGrowthPerDays($growths_data, $fields['category']);
    
                    usort($growth_per_days, function ($a, $b) {
                        return $b['growth_per_day'] - $a['growth_per_day'];
                    });
    
                    $result = [];
    
                    if (count($growth_per_days) <= $fields['n']) {
                        $result = $growth_per_days;
                    } else {
                        for ($i = 0; $i < $fields['n']; $i++) {
                            array_push($result, $growth_per_days[$i]);
                        }
                    }
    
                    return ResponseFormatter::success(
                        $result,
                        'Success get growth insight'
                    );
                } else {
                    return ResponseFormatter::error(
                        [
                            'message' => 'Update terus laporan perkembangan untuk mendapatkan insight-nya!'
                        ],
                        'Growth data count less than 2',
                        400
                    );
                }
            } else {
                return ResponseFormatter::error(
                    null,
                    'Invalid category input',
                    400
                );
            }
        } else {
            return ResponseFormatter::error(
                null,
                'No category input',
                400
            );
        }
    }
}
