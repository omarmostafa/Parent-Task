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



    }
}
