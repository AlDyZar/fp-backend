<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class item_detail extends Model
{
    //
    protected $fillable = [
        'item_id', 'key', 'value'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'id' => 'string'
    ];
    protected $primaryKey = "id";
    //public $timestamps = false;
    public $incrementing = false;
}
