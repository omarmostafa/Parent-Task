<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = ['name','qtn','category','subcategory','order_id'];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function tags()
    {
        return $this->hasMany('App\Tag');
    }
}
