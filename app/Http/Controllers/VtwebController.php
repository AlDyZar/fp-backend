<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\ItemRepository;

use App\Veritrans\Veritrans;

class VtwebController extends Controller
{
    public function __construct(CartRepository $cr, TransactionRepository $tr, ItemRepository $ir)
    {
        $this->cr = $cr;
        $this->tr = $tr;
        $this->ir = $ir;
        Veritrans::$serverKey = 'SB-Mid-server-4EmqIn59cgQy4Ny2GgZ9dwAs';

        //set Veritrans::$isProduction  value to true for production mode
        Veritrans::$isProduction = false;
    }

    public function vtweb() 
    {
        $vt = new Veritrans;
        $user = auth()->user();
        $tempArr = $this->cr->all($user['id']);
        if(count($tempArr) <= 0){
            return response(['msg' => ['Add a product please']]);
        }
        $total = 0;
        $items = [];
        $this->cr->deleteUserCart($user['id']);
        $tr_id = $this->tr->createTransaction($user['id']);
        /*
         * Validate and add total price
         */
        foreach ($tempArr as $temp){
            $total += (int)$temp['price'] * $temp['qty'];
            $arr = [
                'id' => $temp['id'],
                'price' => (int)$temp['price'],
                'quantity' => $temp['qty'],
                'name' => $temp['name'],
            ];
            if($temp['qty'] < $this->ir->find($temp['item'])){

            }
            array_push($items, $arr);
            $this->tr->insertTransactionDetail($tr_id, $temp['id'], $temp['qty']);
        }

        $transaction_details = array(
            'order_id'          => $tr_id,
            'gross_amount'  => $total
        );

        // Populate items
//        $items = [
//            array(
//                'id'                => 'item1',
//                'price'         => 100000,
//                'quantity'  => 1,
//                'name'          => 'Adidas f50'
//            ),
//            array(
//                'id'                => 'item2',
//                'price'         => 50000,
//                'quantity'  => 2,
//                'name'          => 'Nike N90'
//            )
//        ];

        // Populate customer's billing address
        $billing_address = array(
            'first_name'        => $user['name'],
            'last_name'         => $user['last_name'],
            'address'           => $user['address'],
            'city'                  => $user['city'],
            'postal_code'   => $user['postal_code'],
            'phone'                 => $user['phone'],
            'country_code'  => 'IDN'
            );

        // Populate customer's shipping address
        $shipping_address = array(
            'first_name'    => $user['name'],
            'last_name'     => $user['last_name'],
            'address'       => $user['address'],
            'city'              => $user['city'],
            'postal_code' => $user['postal_code'],
            'phone'             => $user['phone'],
            'country_code'=> 'IDN'
            );

        // Populate customer's Info
        $customer_details = array(
            'first_name'            => $user['name'],
            'last_name'             =>  $user['last_name'],
            'email'                     => $user['email'],
            'phone'                     => $user['phone'],
            'billing_address' => $billing_address,
            'shipping_address'=> $shipping_address
            );

        // Data yang akan dikirim untuk request redirect_url.
        // Uncomment 'credit_card_3d_secure' => true jika transaksi ingin diproses dengan 3DSecure.
        $transaction_data = array(
            'payment_type'          => 'vtweb', 
            'vtweb'                         => array(
                //'enabled_payments'    => [],
                'credit_card_3d_secure' => true
            ),
            'transaction_details'=> $transaction_details,
            'item_details'           => $items,
            'customer_details'   => $customer_details
        );
    
        try
        {
            $vtweb_url = $vt->vtweb_charge($transaction_data);
            return response(["url" => $vtweb_url], 200);
        } 
        catch (Exception $e) 
        {
            return response(["msg" => "server error"], 500);
        }
    }

    /*
     * Notification
     */
    public function notification()
    {
        $vt = new Veritrans;
        echo 'test notification handler';
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);

        if($result){
        $notif = $vt->status($result->order_id);
        }

        error_log(print_r($result,TRUE));

        /*
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
          // For credit card transaction, we need to check whether transaction is challenge by FDS or not
          if ($type == 'credit_card'){
            if($fraud == 'challenge'){
              // TODO set payment status in merchant's database to 'Challenge by FDS'
              // TODO merchant should decide whether this transaction is authorized or not in MAP
              echo "Transaction order_id: " . $order_id ." is challenged by FDS";
              } 
              else {
              // TODO set payment status in merchant's database to 'Success'
              echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
              }
            }
          }
        else if ($transaction == 'settlement'){
          // TODO set payment status in merchant's database to 'Settlement'
          echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
          } 
          else if($transaction == 'pending'){
          // TODO set payment status in merchant's database to 'Pending'
          echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
          } 
          else if ($transaction == 'deny') {
          // TODO set payment status in merchant's database to 'Denied'
          echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        }*/
   
    }
}    