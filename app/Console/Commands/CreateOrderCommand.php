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
        $request=$this->argument('order');
        $order=$request->input('order');
        $order=Order::create($order);
        $items=$order['items'];
        foreach ($items as $item) {
            $item=$order->items()->create($item);
            $tags=$item['tags'];
            foreach ($tags as $tag)
            {
                $item->tags()->create(['name'=>$tag]);
            }

        }

        return $order;

    }
}
