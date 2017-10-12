<?php
namespace App\Parent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class CreateOrderValidator
{
    /**
     * orders validation
     * @var array
     */
    protected $ordersRules=[
        'order.order_id'=>"required",
        "order.email"=>"required|email",
        "order.total_amount_net"=>"required",
        "order.shipping_costs"=>"required",
        "order.payment_method"=>"required",
        "order.items"=>"required",
        "order.items.*.name"=>"required",
        "order.items.*.qnt"=>"required",
        "order.items.*.value"=>"required",
        "order.items.*,category"=>"required",
        "order.items.*.subcategory"=>"required",
        "order.items.*.collection_id"=>"required",
        "order.tags.*"=>"required"
    ];
    /**
     * make validation on request
     * @param Request $request
     * @return mixed
     */
    public function validate(Request $request)
    {
        $ordersValidation = Validator::make($request->all(), $this->ordersRules); //consume order validation in request
        return $ordersValidation;
    }
}