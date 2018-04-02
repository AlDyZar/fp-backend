<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    //
    protected $fillable = [
      'user_id', 'item_id', 'qty', 'total', 'status'
    ];
    protected $hidden = [
        'updated_at'
    ];

    protected $casts = [
        'id' => 'string'
    ];
    protected $primaryKey = "id";
    //public $timestamps = false;
    //public $incrementing = false;

    public function detail(){
        return $this->hasMany('App\Models\transaction_detail');
    }
}
