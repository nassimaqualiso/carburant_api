<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Employee;

class CalendarEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Tache::get(['id', 'date_start', 'date_end', 'description', 'employee_id']);
        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployees()
    {
        $employees = Employee::get(['id', 'first_name', 'last_name']);
        return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date_start' => 'required',
            'date_end' => 'required',
            'employeId' => 'required',
            'description' => 'required|min:3'
        ]);
        $tache = new Tache();
        $tache->description = $request->description;
        $tache->date_start = Carbon::parse($request->date_start)->format('Y-m-d H:i');
        $tache->date_end = Carbon::parse($request->date_end)->format('Y-m-d H:i');
        $tache->employee_id = $request->employeId;
        // $tache->employee_id = auth()->user()->id;
        $tache->save();
        //$date_start = Carbon::parse($request->date_start)->format('Y-m-d H:i');, 'title' => $date_start
        return response()->json(['message' => 'Event created with success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function show(Tache $tache)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function edit(Tache $tache)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tache $tach)
    {
        $this->validate($request, [
            'date_start' => 'required',
            'date_end' => 'required',
            'employeId' => 'required',
            'description' => 'required|min:3'
        ]);
        $tache = Tache::findOrFail($request->id);
        $tache->description = $request->description;
        $tache->date_start = Carbon::parse($request->date_start)->format('Y-m-d H:i');
        $tache->date_end = Carbon::parse($request->date_end)->format('Y-m-d H:i');
        $tache->employee_id = $request->employeId;
        $tache->update();
        return response()->json(['message' => 'Event updated with success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tache = Tache::findOrFail($id);
        $tache->delete();
        return response()->noContent();
    }
}
