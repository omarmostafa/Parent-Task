<?php
namespace App\Parent;

use App\Jobs\CreateOrderJob;

class OrderManager
{
    /**
     * total value of order
     * @var float
     */
    protected $orderValue;

    /**
     * Object from Discount Provider to calculate discount value
     * @var DiscountProvider
     */
    protected $discountManager;

    /**
     * array of used collections in items
     * @var array
     */
    protected $collections;

    public function __construct(DiscountProvider $discountManager)
    {
        $this->discountManager=$discountManager;
    }

    /**
     * create order via create order job
     * @param $request
     * @return $this
     */
    public function create($request)
    {
        dispatch(new CreateOrderJob($request->input('order'))); //dispatch create order job to persist order
        $this->orderValue=$request->input('order')['total_amount_net']; //set order total value
        $this->collections=$this->getCollections($request); //set collections
        return $this;
    }

    /**
     * use discount provider to calculate discount value
     * @param $url
     * @return float|int
     */
    public function discountValue($url)
    {
       return $this->discountManager->getDiscountValue($url,$this->collections,$this->orderValue);
    }

    /**
     * get used collections in order
     * @param $request
     * @return array
     */
    public function getCollections($request)
    {
        return array_column($request->input('order')['items'],'collection_id');
    }

}