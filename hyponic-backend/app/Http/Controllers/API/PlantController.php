<?php

namespace App\Http\Controllers\API;

use App\Growth;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Traits\GetGrowthData;
use App\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantController extends Controller
{
    use GetGrowthData;
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
        if($plant->user_id != Auth::user()->id) {
            return ResponseFormatter::error(
                null,
                'Plant data do not belongs to currently authenticated user',
                401
            );
        }

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
        if($plant->user_id != Auth::user()->id) {
            return ResponseFormatter::error(
                null,
                'Plant data do not belongs to currently authenticated user',
                401
            );
        }

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
        if($plant->user_id != Auth::user()->id) {
            return ResponseFormatter::error(
                null,
                'Plant data do not belongs to currently authenticated user',
                401
            );
        }

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

            if (count($plants) > 0) {
                return ResponseFormatter::success(
                    $plants,
                    'Success get plants data'
                );
            } else {
                return ResponseFormatter::error(
                    [
                        'message' => 'Buat data tanaman baru untuk mendapatkan insight-nya!'
                    ],
                    'Empty plants data',
                    404
                );
            }
        } else {
            return redirect('api/plants');
        }
    }

    public function top(Request $request)
    {
        if ($request->input('category')) {
            $fields = $request->validate([
                'category' => 'string|required',
                'n' => 'numeric|required|min:1|max:10'
            ]);

            if (!$fields) {
                return ResponseFormatter::error(
                    null,
                    'Invalid input',
                    400
                );
            }

            if ($fields['category'] == 'plant_height' || $fields['category'] == 'leaf_width') {
                $plants_data = Plant::orderBy('updated_at', 'desc')
                    ->where('user_id', Auth::user()->id)
                    ->get();
                
                if(count($plants_data) > 0) {
                    $plants_growth = [];
                    foreach ($plants_data as $plant) {
                        $growths_data = Growth::where('plant_id', $plant->id)
                            ->orderBy('updated_at', 'desc')
                            ->get();
    
                        if(count($growths_data) > 1) {
                            $growth_per_days = [];
        
                            $growth_per_days = $this->getGrowthPerDays($growths_data, $fields['category']);
        
                            usort($growth_per_days, function ($a, $b) {
                                return $b['growth_per_day'] - $a['growth_per_day'];
                            });
        
                            $plant_growth = [
                                'name' => $plant->name,
                                'growth' => $growth_per_days[0]
                            ];
        
                            array_push($plants_growth, $plant_growth);
                        }
                    }

                    if(count($plants_growth) > 0) {
                        usort($plants_growth, function ($a, $b) {
                            return $b['growth']['growth_per_day'] - $a['growth']['growth_per_day'];
                        });
        
                        $result = [];
                        if (count($plants_growth) <= $fields['n']) {
                            $result = $plants_growth;
                        } else {
                            for ($i = 0; $i < $fields['n']; $i++) {
                                array_push($result, $plants_growth[$i]);
                            }
                        }

                        return ResponseFormatter::success(
                            $result,
                            'Success get plant insight'
                        );
                    } else {
                        return ResponseFormatter::error(
                            [
                                'message' => 'Butuh minimal 2 data perkembangan per tanaman untuk mendapatkan insight pertumbuhan!'
                            ],
                            'No any plant with at least 2 growth data',
                            404
                        );
                    }
    
                } else {
                    return ResponseFormatter::error(
                        [
                            'message' => 'Buat minimal 1 tanaman untuk mendapatkan insight pertumbuhan!'
                        ],
                        'Plant data count less than 1',
                        404
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
