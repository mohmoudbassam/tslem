<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Models\Order;
use Illuminate\Console\Command;

class GenerateLicenseForOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:order:license:generate
                       {order_id : The Order ID}
                       {license_type=1 : The License Type To Generate, ADDON_TYPE=1, EXECUTION_TYPE=2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate System License For Order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setAliases([
                              'order:license:generate',
                              'o:l:g',
                              'ol',
                          ]);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $order_id = $this->argument('order_id');
        $license_type = $this->argument('license_type') ?: 1;
        $license_type = in_array(intval($license_type), [
            License::ADDON_TYPE,
            License::EXECUTION_TYPE,
        ]) ? $license_type : License::ADDON_TYPE;

        if( $order_id ) {
            /** @var \App\Models\Order $order */
            $order = Order::findOrFail($order_id);
            $filename = null;
            $order->generateLicenseFile($filename, $license_type, true, true);
            if( !$filename ) {
                $this->error("Error!");

                return 1;
            }

            $this->info("License path: " . Order::disk()->path($filename));
        } else {
            $licenses = License::ByType($license_type)->get();
            $count = $licenses->count();
            $dbg = fn($type, $msg)=> $this->$type($msg);
            $licenses = $licenses->map(function(License $license) use($dbg) {
                $filename = null;
                try {
                    /** @var Order $order */
                    if( $order = $license->order ) {
                        $filename = null;
                        $order->generateLicenseFile($filename, $license->type, true, true);
                    }
                } catch(\Exception $exception) {
                }
                if( !$filename ) {
                    $dbg('error',"Error!");

                    return false;
                }
                $dbg('info',"License path: " . Order::disk()->path($filename));

                return true;
            })->filter();

            if( $count === $licenses->count() ) {
                $this->info("Licenses Generated! ({$count})");

                return 0;
            }

            $this->error("Error! ({$count}/".$licenses->count().")");

            return 1;
        }

        return 0;
    }
}
