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
//        if($request->input('name')) {
//            $resp = $this->item->paginateSearch(4, $request->input('name'));
//            if(count($resp->toArray()['data'])>0){
//                return response($resp, 200);
//            }else{
//                return response($resp, 404);
//            }
//        }else{
//            $resp = $this->item->paginate(4);
//            if(count($resp->toArray()['data'])>0){
//                return response($resp, 200);
//            }else{
//                return response($resp, 404);
//            }
//        }
        try {
            if ($request->input('name') && $request->input('category')) {
                return $this->iesm->search($request->input('category'), $request->input('name'));
            } else if ($request->input('name')) {
                return $this->iesm->search('item', $request->input('name'));
            } else if ($request->input('category')) {
                return $this->iesm->getAll($request->input('category'));
            } else {
                return $this->iesm->getAll('item');
            }
        }catch (\Exception $e){
            return response(['msg' => ['Server error']], 500);
        }
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
