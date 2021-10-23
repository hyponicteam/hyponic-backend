<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plants = Plant::orderBy('updated_at', 'desc')
            ->where('user_id', Auth::user()->id)
            ->get();

        return ResponseFormatter::success(
            $plants,
            'Success get all plants'
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
            'name' => 'required|string',
        ]);

        if (!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input',
                400
            );
        }

        $plant = Plant::create([
            'name' => $fields['name'],
            'user_id' => Auth::user()->id
        ]);

        return ResponseFormatter::success(
            $plant,
            'New plant data created'
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
        $plant->load('growths');
        
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
            'name' => 'string',
        ]);

        if (!$fields) {
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
            'Plant data updated'
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
            'Plant data deleted'
        );
    }

    public function latest(Request $request)
    {
        if ($request->input('n')) {
            $fields = $request->validate([
                'n' => 'numeric'
            ]);

            if (!$fields) {
                return ResponseFormatter::error(
                    null,
                    'Invalid input',
                    400
                );
            }

            $plants = Plant::orderBy('updated_at', 'desc')
                ->where('user_id', Auth::user()->id)
                ->take($fields['n'])
                ->get()
                ->sortByDesc('updated_at');

            return ResponseFormatter::success(
                $plants,
                'Success get plants data'
            );
        } else {
            return redirect('api/plants');
        }
    }
}
