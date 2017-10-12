<?php

namespace App\Http\Controllers;


use App\Helpers\CreateOrderValidator;
use App\Helpers\OrderManager;
use Illuminate\Http\Request;

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
        $this->orderValidator=$orderValidator;
        $this->orderManager=$orderManager;
    }

    public function order(Request $request)
    {
        $orderValidation=$this->orderValidator->validate($request);
        if($orderValidation->fails())
        {
            $errors =$orderValidation->messages()->toArray();
            return $this->respondNotAcceptable(['msg'=>'Errors in inputs','errors'=>$errors]);
        }

        $discountValue=$this->orderManager->create($request)->discountValue("https://developer.github.com/v3/#http-redirects");

        return $this->respondAccepted(['discount_value'=>$discountValue,'total_amount_net'=>$request->order['total_amount_net'],'shipping_costs'=>$request->order['shipping_costs']]);
    }
}
