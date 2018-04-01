<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category_detail extends Model
{
    //
    protected $fillable = [
      'category_id', 'key'
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
