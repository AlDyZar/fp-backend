<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Repositories\ItemRepository;

class ItemController extends Controller
{
    public function __construct(ItemRepository $item)
    {
        $this->item = $item;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('name')) {
            $resp = $this->item->paginateSearch(4, $request->input('name'));
            if(count($resp->toArray()['data'])>0){
                return response($resp, 200);
            }else{
                return response($resp, 404);
            }
        }else{
            $resp = $this->item->paginate(4);
            if(count($resp->toArray()['data'])>0){
                return response($resp, 200);
            }else{
                return response($resp, 404);
            }
        }
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
        try {
            return $this->item->find($id);
        }catch (\Exception $e){
            return response([
                "msg" => ['server error']
            ], 500);
        }
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
        //
    }
}
