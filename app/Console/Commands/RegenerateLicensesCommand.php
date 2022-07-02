<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Models\Order;
use Illuminate\Console\Command;

class RegenerateLicensesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:license:regenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate System Licenses';

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
     * @return int
     */
    public function handle()
    {

        $addons = Order::where('status', '>=', Order::PENDING_OPERATION)->get()
                       ->each(function(Order $order) {
                           $filename = null;
                           $order->generateLicenseFile($filename, License::ADDON_TYPE, true, true);
                       });

        $ex = Order::where('status', '>=', Order::FINAL_LICENSE_GENERATED)->get()
                   ->each(function(Order $order) {
                       $filename = null;
                       $order->generateLicenseFile($filename, License::EXECUTION_TYPE, true, true);
                   });
        $this->info(
            print_r([
                        'addons' => $addons->count(),
                        'ex' => $ex->count(),
                    ], true)
        );

        return 0;
    }
}
