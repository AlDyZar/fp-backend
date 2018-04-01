<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CartRepository;
use App\Repositories\ItemRepository;
use Tymon\JWTAuth\Exceptions\JWTException;

class CartController extends Controller
{
    public function __construct(CartRepository $cart, ItemRepository $ir)
    {
        $this->cart = $cart;
        $this->ir = $ir;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        //return $user['id'];
        return response($this->cart->all($user['id']), 200);
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
        try {
            $user = auth()->user();
            if($request->input('qty') > $this->ir->find($request->input('item_id'))->qty){
                return response(['msg' => 'Input quantity over stock'], 422);
            }
            return response($this->cart->insert($user['id'], $request->input('item_id'), $request->input('qty')), 200);
        }catch (JWTException $e){
            return response(['msg' => ['Server Error']], 500);
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
        try {
            $data = $this->cart->find($id);
            if($request->input('qty') > $this->ir->find($data['item_id'])->qty){
                return response(['msg' => 'Input quantity over stock'], 422);
            }
            $data->update(['qty' => $request->input('qty')]);
            return response(['status' => true], 200);
        }catch (JWTException $e){
            return response(['msg' => ['Server Error']], 500);
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
        try {
            $this->cart->find($id)->delete();
            return response(['status' => true], 200);
        }catch (JWTException $e){
            return response(['msg' => ['Server Error']], 500);
        }
    }
}
