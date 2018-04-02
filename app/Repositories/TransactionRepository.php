<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 01/04/2018
 * Time: 6:15 PM
 */

namespace App\Repositories;

use App\Models\transaction;
use App\Models\transaction_detail;

class TransactionRepository
{
    public function __construct(transaction $tr, transaction_detail $trd)
    {
        $this->tr = $tr;
        $this->trd = $trd;
    }

    public function all($user_id){
        return $this->tr->where('user_id', $user_id)->get();
    }

    public function find($id){
        return $this->tr->find($id)->detail;
    }

    public function createOneTransaction($user_id, $item_id, $total, $qty){
        $data = transaction::create([
            'user_id' => $user_id,
            'item_id' => $item_id,
            'qty' => $qty,
            'status' => 'PAYMENT',
            'total' => $total
        ]);

        return $data->id;
    }

    public function createTransaction($user_id, $total){
        $transaction = $this->tr->create([
            'user_id' => $user_id,
            'status' => 'PAYMENT',
            'total' => $total
        ]);

        return $transaction['id'];
    }

    public function insertTransactionDetail($transaction_id, $item_id, $qty){
        return $this->trd->create([
            'transaction_id' => $transaction_id,
            'item_id' => $item_id,
            'qty' => $qty
        ]);
    }

}