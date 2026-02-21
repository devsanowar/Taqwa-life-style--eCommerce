<?php

namespace App\Console\Commands;

use App\Models\FlashSale;
use Illuminate\Console\Command;

class FlashSaleStatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashsale:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        FlashSale::where('status','scheduled')
            ->where('auto_start',1)
            ->where('start_at','<=',$now)
            ->update(['status'=>'live']);

        FlashSale::where('status','live')
            ->where('auto_expire',1)
            ->where('end_at','<',$now)
            ->update(['status'=>'ended']);
    }
}