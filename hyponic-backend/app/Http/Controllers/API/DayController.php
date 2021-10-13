<?php

namespace App\Http\Controllers\API;

use App\Day;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $day = Day::all();

        return ResponseFormatter::success(
            $day,
            'Get day list success.'
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
            'plant_id' => 'required|numeric',
            'name' => 'required|string'
        ]);

        if (!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input',
                400
            );
        }

        $day = Day::create([
            'plant_id' => $fields['plant_id'],
            'name' => $fields['name']
        ]);

        return ResponseFormatter::success(
            $day,
            'Success create new day data'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Day $day)
    {
        return ResponseFormatter::success(
            $day,
            'Success get day data'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Day $day)
    {
        if (!$request->input('plant_id') || !$request->input('name')) {
            ResponseFormatter::success(
                null,
                'Invalid input',
                400
            );
        }

        if ($request->input('plant_id')) {
            $fields = $request->validate([
                'plant_id' => 'numeric'
            ]);

            $day->update([
                'plant_id' => $fields['plant_id']
            ]);
        }

        if ($request->input('name')) {
            $fields = $request->validate([
                'name' => 'string'
            ]);

            $day->update([
                'name' => $fields['name']
            ]);
        }

        return ResponseFormatter::success(
            $day,
            'Day updated'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Day $day)
    {
        $day->delete();

        return ResponseFormatter::success(
            null,
            'Day deleted'
        );
    }
}
