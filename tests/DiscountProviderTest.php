<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DiscountProviderTest extends TestCase
{
    protected $discountProvider;

    public function setUp() {

        parent::setUp();

        $this->discountProvider = $this->app->make('App\Parent\DiscountProvider');
    }

    /**
     * test get valid discount value
     *
     * @return void
     */
    public function testGetDiscountValue()
    {

       $discountValue= $this->discountProvider->getDiscountValue("https://developer.github.com/v3/#http-redirects",[12,7],1000);
        $this->assertEquals(21,$discountValue);

    }

    /**
     * get orders with not certain collections
     *
     * @return void
     */
    public function testGetDiscountValueZero()
    {
        $discountValue= $this->discountProvider->getDiscountValue("https://developer.github.com/v3/#http-redirects",[13,7],1000);
        $this->assertEquals(0,$discountValue);
    }

    /**
     * get Discount Value with limit
     *
     * @return void
     */
    public function testGetDiscountWithLimit()
    {
        $discountValue= $this->discountProvider->getDiscountValue("https://developer.github.com/v3/#http-redirects",[12,7],60);
        $this->assertEquals(15,$discountValue);
    }

}
