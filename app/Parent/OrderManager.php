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
     * @param $order
     * @return $this
     */
    public function create($order)
    {
        dispatch(new CreateOrderJob($order)); //dispatch create order job to persist order
        $this->orderValue=$order['total_amount_net']; //set order total value
        $this->collections=$this->getCollections($order); //set collections
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
     * @param $order
     * @return array
     */
    public function getCollections($order)
    {
        return array_column($order['items'],'collection_id');
    }

}