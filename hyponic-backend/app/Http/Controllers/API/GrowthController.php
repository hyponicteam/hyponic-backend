<?php

namespace App\Http\Controllers\API;

use App\Growth;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GrowthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'plant_height' => 'numeric',
            'leaf_width' => 'numeric',
            'temperature' => 'numeric',
            'acidity' => 'numeric',
            'plant_id' => 'string|required'
        ]);

        if(!$fields) {
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
        if($request->input('plant_height')) {
            $fields = $request->validate([
                'plant_height' => 'numeric'
            ]);
            $growth->update([
                'plant_height' => $fields['plant_height']
            ]);
        }

        if($request->input('leaf_width')) {
            $fields = $request->validate([
                'leaf_width' => 'numeric'
            ]);
            $growth->update([
                'leaf_width' => $fields['leaf_width']
            ]);
        }

        if($request->input('temperature')) {
            $fields = $request->validate([
                'temperature' => 'numeric'
            ]);
            $growth->update([
                'temperature' => $fields['temperature']
            ]);
        }

        if($request->input('acidity')) {
            $fields = $request->validate([
                'acidity' => 'numeric'
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
}
