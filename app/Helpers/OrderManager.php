<?php
namespace App\Helpers;


use Illuminate\Support\Facades\Artisan;

class OrderManager
{

    public function __construct()
    {
    }

    public function create($request)
    {
        Artisan::call('order:create', [
            'order' => $request->input('order')
        ]);
    }

}