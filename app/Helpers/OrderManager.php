<?php
namespace App\Helpers;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Artisan;

class OrderManager
{
    protected $client;

    protected $orderValue;

    protected $discountManager;
    
    protected $collections;

    public function __construct(Client $client,DiscountManager $discountManager)
    {
        $this->client=$client;
        $this->discountManager=$discountManager;
    }

    public function create($request)
    {
        $orderValue=Artisan::call('order:create', [
            'order' => $request->input('order')
        ]);
        $this->orderValue=$orderValue;
        $this->collections=$this->getCollections($request);
        return $this;
    }

    public function discountValue($url)
    {
       return $this->discountManager->getDiscountValue($url,$this->collections,$this->orderValue);
    }

    public function getCollections($request)
    {
        return array_column($request->input('order')['items'],'collection_id');
    }

}