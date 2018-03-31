<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    //
    protected $fillable = [
        'user_id', 'item_id', 'qty'
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

    public function item()
    {
        return $this->belongsTo('App\Models\item');
    }
}
