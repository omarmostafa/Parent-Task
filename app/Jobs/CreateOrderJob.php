<?php

namespace App\Jobs;

use App\Order;

class CreateOrderJob extends Job
{
    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order=$order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order_items=$this->order;
        $order=Order::create($order_items);
        $items=$order_items['items'];
        foreach ($items as $item) {
            $item_element=$order->items()->create($item);
            $tags=$item['tags'];
            foreach ($tags as $tag)
            {
                $item_element->tags()->create(['name'=>$tag]);
            }
        }
    }
}
