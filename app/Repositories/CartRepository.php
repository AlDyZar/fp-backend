<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 29/03/2018
 * Time: 1:02 AM
 */

namespace App\Repositories;

use App\Models\cart;

class CartRepository{

    public function __construct(cart $cart)
    {
        $this->cart = $cart;
    }

    public function all($user_id){
        $cart = $this->cart->where('user_id', $user_id)->get();
        //return $cart;
        $items = [];
        foreach ($cart as $item){
            //return $item->item;
            array_push($items, $item->item);
        }
        return $items;
    }

    public function insert($user_id, $item_id, $qty) {
        return $this->cart->create([
            'user_id' => $user_id,
            'item_id' => $item_id,
            'qty' => $qty
        ]);
    }

    public function update($user_id, $id, $qty){
        return $this->cart->where('user_id', $user_id)->where('id', $id)->update(['qty'=>$qty]);
    }

    public function delete($user_id, $id){
        return $this->cart->where('user_id', $user_id)->where('id', $id)->delete();
    }

}