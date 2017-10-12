<?php
namespace App\Parent;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class DiscountService
{
    /**
     * define client of guzzle package to get content from url
     * @var Client
     */
    protected $client;


    public function __construct(Client $client)
    {
        $this->client=$client;
    }

    /**
     * calculate discount value from url and count status value from url
     * @param $url
     * @return int
     */
    public function getDiscountValueFromUrl($url)
    {
        $response=$this->client->get($url);
        $response=$response->getBody()->getContents();
        $count=substr_count($response,Config::get('config.word'));
        return $count;
    }

}