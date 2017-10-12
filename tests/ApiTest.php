<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{
    /**
     * Test Email Validation
     *
     * @return void
     */
    public function testEmailValidation()
    {
        $request=["order"=>["order_id"=> 51275, "email"=>"test email", "total_amount_net"=> "1890.00", "shipping_costs"=> "29.00", "payment_method"=> "VISA",
        "items"=>[
            ["name"=> "Item1", "qnt"=> 1, "value"=> 1100, "category"=> "Fashion", "subcategory"=> "Jacket", "tags"=> ["porsche", "design"], "collection_id"=> 12],
            ["name"=> "Item2", "qnt"=> 1, "value"=> 790, "category"=> "Watches", "subcategory"=> "sport", "tags"=> ["watch", "porsche", "electronics"], "collection_id"=> 7]
            ]
        ]];
        $this->json('POST', '/api/v1/orders',$request)
            ->seeJson([
                'success' => false,
            ]);
    }

    /**
     * Test Total Amount Positive Validation
     *
     * @return void
     */
    public function testTotalAmountPositiveValue()
    {
        $request=["order"=>["order_id"=> 51275, "email"=>"test@gmail.com", "total_amount_net"=> "-1890.00", "shipping_costs"=> "29.00", "payment_method"=> "VISA",
            "items"=>[
                ["name"=> "Item1", "qnt"=> 1, "value"=> 1100, "category"=> "Fashion", "subcategory"=> "Jacket", "tags"=> ["porsche", "design"], "collection_id"=> 12],
                ["name"=> "Item2", "qnt"=> 1, "value"=> 790, "category"=> "Watches", "subcategory"=> "sport", "tags"=> ["watch", "porsche", "electronics"], "collection_id"=> 7]
            ]
        ]];
        $this->json('POST', '/api/v1/orders',$request)
            ->seeJson([
                'success' => false,
            ]);
    }


    /**
     * Test Total Amount Numeric Validation
     *
     * @return void
     */
    public function testTotalAmountNumericValue()
    {
        $request=["order"=>["order_id"=> 51275, "email"=>"test@gmail.com", "total_amount_net"=> "test", "shipping_costs"=> "29.00", "payment_method"=> "VISA",
            "items"=>[
                ["name"=> "Item1", "qnt"=> 1, "value"=> 1100, "category"=> "Fashion", "subcategory"=> "Jacket", "tags"=> ["porsche", "design"], "collection_id"=> 12],
                ["name"=> "Item2", "qnt"=> 1, "value"=> 790, "category"=> "Watches", "subcategory"=> "sport", "tags"=> ["watch", "porsche", "electronics"], "collection_id"=> 7]
            ]
        ]];
        $this->json('POST', '/api/v1/orders',$request)
            ->seeJson([
                'success' => false,
            ]);
    }

    /**
     * Test Total Amount Numeric Validation
     *
     * @return void
     */
    public function testOrderIdRequiredValue()
    {
        $request=["order"=>["email"=>"test@gmail.com", "total_amount_net"=> "1890", "shipping_costs"=> "29.00", "payment_method"=> "VISA",
            "items"=>[
                ["name"=> "Item1", "qnt"=> 1, "value"=> 1100, "category"=> "Fashion", "subcategory"=> "Jacket", "tags"=> ["porsche", "design"], "collection_id"=> 12],
                ["name"=> "Item2", "qnt"=> 1, "value"=> 790, "category"=> "Watches", "subcategory"=> "sport", "tags"=> ["watch", "porsche", "electronics"], "collection_id"=> 7]
            ]
        ]];
        $this->json('POST', '/api/v1/orders',$request)
            ->seeJson([
                'success' => false,
            ]);
    }

    /**
     * Test Successful Order
     *
     * @return void
     */
    public function testSuccessfulOrder()
    {
        $request=["order"=>["order_id"=> 51275,"email"=>"test@gmail.com", "total_amount_net"=> "1890", "shipping_costs"=> "29.00", "payment_method"=> "VISA",
            "items"=>[
                ["name"=> "Item1", "qnt"=> 1, "value"=> 1100, "category"=> "Fashion", "subcategory"=> "Jacket", "tags"=> ["porsche", "design"], "collection_id"=> 12],
                ["name"=> "Item2", "qnt"=> 1, "value"=> 790, "category"=> "Watches", "subcategory"=> "sport", "tags"=> ["watch", "porsche", "electronics"], "collection_id"=> 7]
            ]
        ]];
        $this->json('POST', '/api/v1/orders',$request)
            ->seeJson([
                'success' => true,
            ]);
    }

    /**
     * Test Successful Order but discount zero
     *
     * @return void
     */
    public function testSuccessfulOrderWithoutDiscount()
    {
        $request=["order"=>["order_id"=> 51275,"email"=>"test@gmail.com", "total_amount_net"=> "1890", "shipping_costs"=> "29.00", "payment_method"=> "VISA",
            "items"=>[
                ["name"=> "Item1", "qnt"=> 1, "value"=> 1100, "category"=> "Fashion", "subcategory"=> "Jacket", "tags"=> ["porsche", "design"], "collection_id"=> 13],
                ["name"=> "Item2", "qnt"=> 1, "value"=> 790, "category"=> "Watches", "subcategory"=> "sport", "tags"=> ["watch", "porsche", "electronics"], "collection_id"=> 7]
            ]
        ]];
        $this->json('POST', '/api/v1/orders',$request)
            ->seeJson([
                'discount_value' => 0,
            ]);
    }

    /**
     * test storing orders in database
     *
     * @return void
     */
    public function testCreateOrderInDatabase()
    {
        $this->seeInDatabase('orders', ['email' => 'test@gmail.com']);
    }

}
