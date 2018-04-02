<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Repositories\ItemRepository;
use App\ElasticSearchModels\ItemElasticSearchModel;

class ItemController extends Controller
{
    public function __construct(ItemRepository $item, ItemElasticSearchModel $iesm)
    {
        $this->item = $item;
        $this->iesm = $iesm;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('name')) {
            $resp = $this->item->allName($request->input('name'));
            if(count($resp->toArray())>0){
                return response($resp, 200);
            }else{
                return response($resp, 404);
            }
        }else{
            $resp = $this->item->all();
            if(count($resp->toArray())>0){
                return response($resp, 200);
            }else{
                return response($resp, 404);
            }
        }
//        try {
//            if ($request->input('name')) {
//                return $this->iesm->search($request->input('name'))['hits'];
//            }
//        }catch (\Exception $e){
//            return response(['msg' => ['Server error']], 500);
//        }
    }

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
}
