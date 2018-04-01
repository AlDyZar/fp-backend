<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ElasticSearchModels\HistoryElasticSearchModel;
use App\ElasticSearchModels\HistoryDetailElasticSearchModel;

class HistoryController extends Controller
{
    public function __construct(HistoryElasticSearchModel $hesm, HistoryDetailElasticSearchModel $hdesm)
    {
        $this->hesm = $hesm;
        $this->hdesm = $hdesm;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try{
            $user = auth()->user();
            return response($this->hesm->getAll($user['id']), 200);
        }catch(\Exception $e){
            return response(['msg' => ['Server error'], 500]);
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
            return response($this->hdesm->getAll($id), 200);
        }catch(\Exception $e){
            return response(['msg' => ['Server error'], 500]);
        }
    }


}
