<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TransactionRepository;

class AppTransactionController extends Controller
{

    public function __construct(TransactionRepository $tr)
    {
        $this->tr = $tr;
    }

    public function index()
    {
        try{
            $user = auth()->user();
            return $this->tr->all($user['id']);
        }catch(\Exception $e){
            return response(['msg' => ['Server Error'], 500]);
        }
    }

    public function show($id)
    {
        //
        try{
            return $this->tr->find($id);
        }catch(\Exception $e){
            return response(['msg' => ['Server Error'], 500]);
        }
    }

}
