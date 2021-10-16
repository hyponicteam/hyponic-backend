<?php

namespace App\Http\Controllers\API;

use App\DailyActivity;
use App\Day;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $daily_activities = DailyActivity::with(['plant'])->where('user_id', $user_id);

        return ResponseFormatter::success(
            $daily_activities->get(),
            'Success get daily activiy list.'
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
            'plant_id' => 'numeric|required',
            'name' => 'string|required'
        ]);

        if (!$fields) {
            return ResponseFormatter::error(
                null,
                'No plant ID given.',
                400
            );
        }

        $plant = Plant::query()->where('id', $fields['plant_id']);

        if (!$plant) {
            return ResponseFormatter::error(
                null,
                'Plant with ID: ' . $fields['plant_id'] . ' not found.',
                404
            );
        }

        $user_id = Auth::user()->id;

        $daily_activity = DailyActivity::create([
            'user_id' => $user_id,
            'plant_id' => $fields['plant_id'],
            'name' => $fields['name']
        ]);

        // isi data pivot
        $plant_id = $daily_activity->plant_id;
        $days = Day::all()->where('plant_id', $plant_id);

        foreach ($days as $day) {
            $todos = $day->todos()->get();
            foreach ($todos as $todo) {
                $daily_activity->todo_days()->attach($todo->days()->where('day_id', $day->id)->first()->pivot->id);
            }
        }

        return ResponseFormatter::success(
            $daily_activity,
            'Success create daily activity'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = Auth::user()->id;
        $daily_activity = DailyActivity::with(['plant', 'todo_days' => function ($todo_day) use ($id) {
            $todo_day->with(['todo', 'day'])->where('daily_activity_id', $id);
        }])->where('user_id', $user_id)->find($id);

        if (!$daily_activity) {
            return ResponseFormatter::error(
                null,
                'Daily activity with ID: ' + $id + ' not found.',
                404
            );
        }

        return ResponseFormatter::success(
            $daily_activity,
            'Success get daily activity'
        );
        // if ($id) {
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $daily_activity = DailyActivity::where('user_id', $user_id)->find($id);

        if (!$daily_activity) {
            return ResponseFormatter::error(
                null,
                'Daily activity with ID: ' . $id . ' not found.',
                404
            );
        }

        $name = $request->input('name');

        if ($name) {
            $daily_activity->update([
                'name' => $name
            ]);
        }

        return ResponseFormatter::success(
            $daily_activity,
            'Daily activity with ID: ' . $id . ' updated.'
        );
    }

    public function check(Request $request, $id)
    {
        $todo_day_id = $request->input('todo_day_id');

        $user_id = Auth::user()->id;

        // ambil model daily activity by id untuk auth user
        $daily_activity = DailyActivity::with(['todo_days' => function($todo_day) use ($todo_day_id){
            $todo_day->where('todo_day_id', $todo_day_id)->first();
        }])->where('user_id', $user_id)->find($id);
        
        if (!$daily_activity) {
            return ResponseFormatter::error(
                null,
                'Daily activity with ID: ' . $id . ' not found.',
                404
            );
        }

        // ambil nilai checked dari tabel todo_check dengan todo_day tertentu dan daily_activity tertentu
        $checked = $daily_activity->todo_days()->where('todo_day_id', $todo_day_id)->first()->pivot->checked;
    
        // mengupdate nilai checked
        $daily_activity->todo_days()->updateExistingPivot($todo_day_id, ['checked' => $checked == false ? true : false]);
    
        return ResponseFormatter::success(
            $daily_activity,
            'Success'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        $daily_activity = DailyActivity::with(['plant.days.todos'])->where('user_id', $user_id)->find($id);
        
        if (!$daily_activity) {
            return ResponseFormatter::error(
                null,
                'Daily activity with ID: ' . $id . ' not found.',
                404
            );
        }
        
        $daily_activity->todo_days()->detach();
        $daily_activity->delete();

        return ResponseFormatter::success(
            null,
            'Daily activity with ID: ' . $id . ' deleted.'
        );
    }
}
