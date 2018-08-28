<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instance;
use App\Customer;
use DB;

class InstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instances = DB::table('instances')->orderBy('id', 'desc')->paginate(20);
        $customers = DB::table('customers')
            ->join('instances', 'customers.id', '=', 'instances.customer_id')->get();
        foreach ($instances as $key) {
          $key->wildcard = DB::table('customers')->where('id', $key->customer_id)->select('full_name')->first();
          $key->wildcard = $key->wildcard->full_name;
        }
        return view('instances', ['instances' => $instances, 'customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create_instance');
    }

    public function create_with_user($user_id)
    {
      $c = Customer::find($user_id);
      return view('create_instance')->with('customer', $c);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $i = new Instance;
      $i->customer_id = $request->current_customer;
      $i->subject = $request->subject;
      $i->recommendations = $request->recommendations;
      $i->fee = $request->fee;
      $i->state = 'Pendiente';
      if ($i->save()) {
        return redirect()->action('InstanceController@index');
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $i = Instance::find($id);
      $c = Customer::find($i->customer_id);
      return view('instance', ['instance' => $i, 'customer' => $c]);
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
      $i = Instance::find($id);
      $i->customer_id = $request->id_customer;
      $i->subject = $request->subject;
      $i->recommendations = $request->recommendations;
      $i->fee = $request->fee;
      $i->state = $request->state;
      if ($i->save()) {
        return redirect()->action('InstanceController@index');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
