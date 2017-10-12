<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 10/12/17
 * Time: 12:22 AM
 */

namespace App\Helpers;


class DiscountManager
{
    protected $certainCollections;

    public function __construct()
    {
        $this->certainCollections=[12,7];
    }

    public function getDiscountValue($url,$collections,$orderValue)
    {
        $count=$this->getDiscountValueFromUrl($url);
        if(!$this->checkItemsInCertainCollection($collections))
        {
            return 0;
        }
        return $this->checkDiscountValueLimit($count,$orderValue);
    }
    
    public function getDiscountValueFromUrl($url)
    {
        $response=file_get_contents($url);
        $count=substr_count($response,'status');
        return $count;
    }

    public function checkItemsInCertainCollection($collections)
    {
        $collections=array_unique($collections);
        return count(array_intersect($collections, $this->certainCollections)) == count($collections);
    }

    public function checkDiscountValueLimit($count,$orderValue)
    {
        if($count > $orderValue*25/100)
        {
            return $orderValue*25/100;
        }
        return $count;
    }
    
}