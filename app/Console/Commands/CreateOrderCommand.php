<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order;
class CreateOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:create {order}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $order_items=$this->argument('order');
        $order=Order::create($order_items);
        $items=$order_items['items'];
        $order_value=0;
        foreach ($items as $item) {
            $item_element=$order->items()->create($item);
            $tags=$item['tags'];
            $order_value+=$item['value'];
            foreach ($tags as $tag)
            {
                $item_element->tags()->create(['name'=>$tag]);
            }
        }

        return $order_value;

    }
}
