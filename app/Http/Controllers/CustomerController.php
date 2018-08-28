<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = DB::table('customers')->orderBy('id', 'desc')->paginate(20);
        return view('customers')->with('customers', $customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create_customer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $c = new Customer;
        $c->id_card = $request->id_card;
        $c->full_name = $request->full_name;
        $c->mobile = $request->mobile;
        $c->phone = $request->phone;
        $c->email = $request->email;
        $c->address = $request->address;
        if ($c->save()) {
          return redirect()->action('CustomerController@index');
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
        $c = Customer::find($id);
        return view('customer')->with('customer', $c);
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
        $c = Customer::find($id);
        $c->id_card = $request->id_card;
        $c->full_name = $request->full_name;
        $c->mobile = $request->mobile;
        $c->phone = $request->phone;
        $c->email = $request->email;
        $c->address = $request->address;
        if ($c->save()) {
          return redirect()->back()->with('customer', $c);
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

    public function showByQuery($query){
      $customers = DB::table('customers')->where('full_name', 'ILIKE', $query.'%')
                                    ->orWhere('id_card', 'ILIKE', $query.'%')
                                    ->get();
      return response()->json(['customers'=> $customers, 'code' => 200]);
    }
}
