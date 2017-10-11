<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = ['order_id','email','total_amount_net','shipping_costs','payment_method'];

    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
