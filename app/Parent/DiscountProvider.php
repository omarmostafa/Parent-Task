<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 10/12/17
 * Time: 12:22 AM
 */

namespace App\Parent;

use Illuminate\Support\Facades\Config;

class DiscountProvider
{
    /**
     * certain collections
     * @var array
     */
    protected $certainCollections;

    /**
     * discount service to get count of status from url
     * @var DiscountService
     */
    protected $service;

    public function __construct(DiscountService $service)
    {
        $this->certainCollections=Config::get('config.collections'); // set certain collections
        $this->service=$service; // dependency injection for discount service
    }

    /**
     * take url and collections and order value to get discount value
     * @param $url
     * @param $collections
     * @param $orderValue
     * @return float|int
     */
    public function getDiscountValue($url,$collections,$orderValue)
    {
        $count=$this->service->getDiscountValueFromUrl($url); //get count of status word in url
        if(!$this->checkItemsInCertainCollection($collections)) // check if check items in certain collection
        {
            return 0; // discount_value will have positive value only if items in order belongs to certain collections, otherwise value should be equal to 0.
        }
        return $this->checkDiscountValueLimit($count,$orderValue); // Maximum possible amount of discount_value has to be 25% of the value of Order.
    }

    /**
     * check items in certain collections
     * @param $collections
     * @return bool
     */
    public function checkItemsInCertainCollection($collections)
    {
        $collections=array_unique($collections);
        return count(array_intersect($collections, $this->certainCollections)) == count($collections);
    }

    /**
     * check if discount value exceed the limit
     * @param $count
     * @param $orderValue
     * @return float|int
     */
    public function checkDiscountValueLimit($count,$orderValue)
    {
        $limit=Config::get('config.limit');
        if($count > $orderValue*$limit/100)
        {
            return $orderValue*$limit/100;
        }
        return $count;
    }
    
}