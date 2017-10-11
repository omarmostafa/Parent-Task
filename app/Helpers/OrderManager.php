<?php
namespace App\Helpers;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Artisan;

class OrderManager
{
    protected $client;

    protected $orderValue;

    public function __construct(Client $client)
    {
        $this->client=$client;
    }

    public function create($request)
    {
        $orderValue=Artisan::call('order:create', [
            'order' => $request->input('order')
        ]);
        $this->orderValue=$orderValue;
        return $this;
    }

    public function getDiscountValue($url)
    {
        $response=file_get_contents($url);
        $count=substr_count($response,'status');
        return $count;
    }

}