<?php

namespace App\Http\Controllers;


use App\Parent\CreateOrderValidator;
use App\Parent\OrderManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class OrderController extends ApiController
{
    protected $orderValidator;

    protected $orderManager;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CreateOrderValidator $orderValidator,OrderManager $orderManager)
    {
        $this->orderValidator=$orderValidator; //dependency injection for Order Validation
        $this->orderManager=$orderManager; // create object mn order manager
    }

    /**
     * this function validate request, create order and return discount value with total amount and shipping cost
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request)
    {
        $orderValidation=$this->orderValidator->validate($request); //call order validation to validate request
        if($orderValidation->fails())
        {
            $errors =$orderValidation->messages()->toArray();
            return $this->respondNotAcceptable(['msg'=>'Errors in inputs','errors'=>$errors]);
        }
        $url=Config::get('config.url');
        $discountValue=$this->orderManager->create($request)->discountValue($url); // call Order manager to create order and get discount value

        return $this->respondAccepted(['discount_value'=>$discountValue,'total_amount_net'=>$request->order['total_amount_net'],'shipping_costs'=>$request->order['shipping_costs']]);
    }
}
