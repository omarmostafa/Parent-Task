<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OrderManagerTest extends TestCase
{
    protected $orderManager;

    public function setUp() {

        parent::setUp();

        $this->orderManager = $this->app->make('App\Parent\OrderManager');
    }
    /**
     * test Create Order Job in database
     *
     * @return void
     */
    public function testCreateOrder()
    {
        $order=["order_id"=> 51275,"email"=>"test@parent.com", "total_amount_net"=> "1890", "shipping_costs"=> "29.00", "payment_method"=> "VISA",
            "items"=>[
                ["name"=> "Item1", "qnt"=> 1, "value"=> 1100, "category"=> "Fashion", "subcategory"=> "Jacket", "tags"=> ["porsche", "design"], "collection_id"=> 12],
                ["name"=> "Item2", "qnt"=> 1, "value"=> 790, "category"=> "Watches", "subcategory"=> "sport", "tags"=> ["watch", "porsche", "electronics"], "collection_id"=> 7]
            ]
        ];

        $this->orderManager->create($order);

        $this->seeInDatabase('orders', ['email' => 'test@parent.com']);
    }

    /**
     * test Get Discount Value as positive
     *
     * @return void
     */
    public function testGetDiscountValue()
    {
        $order=["order_id"=> 51275,"email"=>"test@parent.com", "total_amount_net"=> "1890", "shipping_costs"=> "29.00", "payment_method"=> "VISA",
            "items"=>[
                ["name"=> "Item1", "qnt"=> 1, "value"=> 1100, "category"=> "Fashion", "subcategory"=> "Jacket", "tags"=> ["porsche", "design"], "collection_id"=> 12],
                ["name"=> "Item2", "qnt"=> 1, "value"=> 790, "category"=> "Watches", "subcategory"=> "sport", "tags"=> ["watch", "porsche", "electronics"], "collection_id"=> 7]
            ]
        ];

        $discountValue=$this->orderManager->create($order)->discountValue("https://developer.github.com/v3/#http-redirects");

        $this->assertEquals(21,$discountValue);
    }

    /**
     * test Get Discount Value as zero
     *
     * @return void
     */
    public function testGetDiscountValueAsZero()
    {
        $order=["order_id"=> 51275,"email"=>"test@parent.com", "total_amount_net"=> "1890", "shipping_costs"=> "29.00", "payment_method"=> "VISA",
            "items"=>[
                ["name"=> "Item1", "qnt"=> 1, "value"=> 1100, "category"=> "Fashion", "subcategory"=> "Jacket", "tags"=> ["porsche", "design"], "collection_id"=> 13],
                ["name"=> "Item2", "qnt"=> 1, "value"=> 790, "category"=> "Watches", "subcategory"=> "sport", "tags"=> ["watch", "porsche", "electronics"], "collection_id"=> 7]
            ]
        ];

        $discountValue=$this->orderManager->create($order)->discountValue("https://developer.github.com/v3/#http-redirects");

        $this->assertEquals(0,$discountValue);
    }

    /**
     * test Get Collections
     *
     * @return void
     */
    public function testGetCollections()
    {
        $order=["order_id"=> 51275,"email"=>"test@parent.com", "total_amount_net"=> "1890", "shipping_costs"=> "29.00", "payment_method"=> "VISA",
            "items"=>[
                ["name"=> "Item1", "qnt"=> 1, "value"=> 1100, "category"=> "Fashion", "subcategory"=> "Jacket", "tags"=> ["porsche", "design"], "collection_id"=> 13],
                ["name"=> "Item2", "qnt"=> 1, "value"=> 790, "category"=> "Watches", "subcategory"=> "sport", "tags"=> ["watch", "porsche", "electronics"], "collection_id"=> 7]
            ]
        ];

        $collections=$this->orderManager->getCollections($order);
        $expectedValue=[13,7];
        $this->assertEquals($expectedValue,$collections);
    }
}
