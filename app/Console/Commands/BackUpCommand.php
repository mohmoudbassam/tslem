<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class BackUpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:command';

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
     * @return int
     */
    public function handle()
    {
        $time=str_replace(':','_',now()->format('H:i'));

        $filename = "backup-" . Carbon::now()->format('Y-m-d').'_'."$time". ".sql";
         $databasename = env('DB_DATABASE');
         $password = env('DB_PASSWORD');
         $filePath=storage_path('/backup/'.$filename);
//         $command="mysqldump -u root -p $password $databasename >".$filePath;

       // $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . storage_path() .'\\'  . $filename;
//        $result=exec($command,$filename,$output);

        $result=exec("mysqldump $databasename --password=$password --user=root --single-transaction >".$filePath,$output);

    }
}
