<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConcreteAction;
use DateTime;
use DB;

class ConcreteActionController extends Controller
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

    public function save($instance_id, $action, $reminder){
      $concreteAction = new ConcreteAction;
      $concreteAction->instance_id = $instance_id;
      $concreteAction->action = $action;
      $concreteAction->reminder = DateTime::createFromFormat('d-m-Y', $reminder)->format('Y-m-d');
      if($concreteAction->save()){
        $actions = ConcreteAction::all();
        return response()->json(['code' => 201, 'actions' => $actions]);
      }
      return response()->json(['code' => 400]);
    }

    public function get($instance_id){
      $actions = DB::table('concrete_actions')->where('instance_id', $instance_id)->get();
      foreach ($actions as $key) {
        $key->reminder = DateTime::createFromFormat('Y-m-d', $key->reminder)->format('d-m-Y');
      }
      return response()->json(['code' => 200, 'actions' => $actions]);
    }

    public function showByDate($date){
      $actions = DB::table('instances')
                        ->join('customers', 'instances.customer_id', '=', 'customers.id')
                        ->join('concrete_actions', function ($join) use ($date){
                          $join->on('instances.id', '=', 'concrete_actions.instance_id')
                               ->where('reminder', '=', $date);
                        })
                        ->get();
      return response()->json(['code' => 200, 'actions' => $actions]);
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
        ConcreteAction::destroy($id);
        return response()->json(['code' => 200]);
    }
}
