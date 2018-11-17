<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Returns the information about a client
     * 
     * @param Request $request
     * @return Response
     */
    public function show(Request $request, $id){
        app('session')->put('name', rand());

        //dd(app('session')->all());
        return response()->json(\DB::select("SELECT * FROM `dec353_2`.`client_view`"));
    }

    //
    public function showAccount(){

    }

    public function create(Request $request){
        return response()->json("Test");
    }

    public function delete(){

    }

    public function update(){

    }
}
