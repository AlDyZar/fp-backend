<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 29/03/2018
 * Time: 12:56 AM
 */

namespace App\Repositories;

use App\Models\item;
use App\Models\item_detail;

class ItemRepository{

    public function __construct(item $item)
    {
        $this->item = $item;
    }

    public function paginateSearch($perpage, $name){
        return $this->item->where('name','ILIKE' ,'%'.$name.'%')->paginate($perpage);
    }

    public function paginate($perpage) {
        return $this->item->paginate($perpage);
    }

    public function find($id){
        return $this->item->find($id);
    }

}