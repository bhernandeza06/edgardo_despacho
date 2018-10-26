<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reminder;
use DateTime;
use DB;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function save($instance_id, $reminder, $reminder_date){
      $r = new Reminder;
      $r->instance_id = $instance_id;
      $r->reminder = $reminder;
      $r->reminder_date = DateTime::createFromFormat('d-m-Y', $reminder_date)->format('Y-m-d');
      if($r->save()){
        $reminders = Reminder::all();
        return response()->json(['code' => 201, 'reminders' => $reminders]);
      }
      return response()->json(['code' => 400]);
    }

    public function get($instance_id){
      $reminders = DB::table('reminders')->where('instance_id', $instance_id)->get();
      foreach ($reminders as $key) {
        $key->reminder_date = DateTime::createFromFormat('Y-m-d', $key->reminder_date)->format('d-m-Y');
      }
      return response()->json(['code' => 200, 'reminders' => $reminders]);
    }

    public function showByDate($date){
      $reminders = DB::table('instances')
                        ->join('customers', 'instances.customer_id', '=', 'customers.id')
                        ->join('reminders', function ($join) use ($date){
                          $join->on('instances.id', '=', 'reminders.instance_id')
                               ->where('reminder_date', '=', $date);
                        })
                        ->get();
      return response()->json(['code' => 200, 'reminders' => $reminders]);
    }

    public function showAllDates(){
      $reminders = DB::table('instances')
                        ->join('customers', 'instances.customer_id', '=', 'customers.id')
                        ->join('reminders', 'instances.id', '=', 'reminders.instance_id')
                        ->get();
      return response()->json(['code' => 200, 'reminders' => $reminders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Reminder::destroy($id);
      return response()->json(['code' => 200]);
    }
}
