<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plant = Plant::all();

        return ResponseFormatter::success(
            $plant,
            'Get plant list success.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string'
        ]);

        if(!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input',
                400
            );
        }

        $plant = Plant::create([
            'name' => $fields['name']
        ]);

        return ResponseFormatter::success(
            $plant,
            'Success create new plant data'
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Plant $plant)
    {
        return ResponseFormatter::success(
            $plant,
            'Success get plant data'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plant $plant)
    {
        $fields = $request->validate([
            'name' => 'required|string'
        ]);

        if(!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input',
                400
            );
        }

        $plant->update([
            'name' => $fields['name']
        ]);

        return ResponseFormatter::success(
            $plant,
            'Plant updated'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plant $plant)
    {
        $plant->delete();

        return ResponseFormatter::success(
            null,
            'Plant deleted'
        );
    }
}
