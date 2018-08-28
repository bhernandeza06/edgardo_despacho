<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use DB;

class DocumentController extends Controller
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

    public function save($instance_id, $title, $link){
      $d = new Document;
      $d->instance_id = $instance_id;
      $d->title = $title;
      $d->link = $link;
      if($d->save()){
        $docs = Document::all();
        return response()->json(['code' => 201, 'docs' => $docs]);
      }
      return response()->json(['code' => 400]);
    }

    public function get($instance_id){
      $docs = DB::table('documents')->where('instance_id', $instance_id)->get();
      return response()->json(['code' => 200, 'docs' => $docs]);
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
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Document::destroy($id);
      return response()->json(['code' => 200]);
    }
}
