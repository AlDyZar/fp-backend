<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;

class CategoryController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return category::whereNull('parent_id')->get();
        }catch(\Exception $e){
            return response(['msg' => ['Server error']], 500);
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
        //
        try{
            return category::where('parent_id', $id)->get();
        }catch(\Exception $e){
            return response(['msg' => ['Server error']], 500);
        }
    }


}
