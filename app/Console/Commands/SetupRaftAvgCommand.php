<?php

namespace App\Console\Commands;

use App\Models\RaftCompanyLocation;
use Illuminate\Console\Command;

class SetupRaftAvgCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:raft-company-avg
{--i|id= : ID of company}
{--a|avg= : AVG company}
{--m|migrate : Run migrate command}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup default avg of companies';

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
     * @return void
     */
    public function handle()
    {
        $this->write("Start setup >> pass option [m] to migrate", 'c');
        if ($this->option('migrate')) {
            if (!$this->confirm('Run migrate command?')) {
                $this->write('Bye', 'c');
                return;
            }
            $this->call('migrate');
        }
        $id = $this->option('id');
        $avg = $this->option('avg');
        if (($id && !$avg) || (!$id && $avg)) {
            $this->error("Please Enter ID & AVG Value.");
            $this->write("Example 1 >> php artisan setup:raft-company-avg --id=2 --avg=88");
            $this->write("Example 2 >> php artisan setup:raft-company-avg -i2 -a88");
            return;
        }
        if ($id && $avg) {
            $res = RaftCompanyLocation::findOrFail($id)->first()->update(['avg' => $avg]);
            $this->write("ID[$id] > Result: $res");
            return;
        }
        // # Defaults.
        $list = [
            'شركة مطوفي حجاج جنوب شرق اسيا'                        => 74,
            'شركة مطوفي حجاج جنوب اسيا'                            => 172,
            'شركة مطوفي حجاج افريقيا غير العربية'                  => 52,
            'شركة مطوفي حجاج الدول العربية'                        => 100,
            'شركة مطوفي حجاج تركيا وحجاج اوروبا وامريكا واستراليا' => 70,
            'شركة مطوفي حجاج ايران'                                => 0,
            'المجلس التنسيقي لمؤسسات وشركات خدمة حجاج الداخل'      => 0,
        ];
        $i = 0;
        foreach ($list as $name => $avg) {
            if (!($model = RaftCompanyLocation::where('name', $name)->first())) {
                $this->error("Model [$i] not found. Skip");
            }
            $r = $model->update(['avg' => $avg]);
            $this->write("Result of [$i] = $r", 'b');
            ++$i;
        }
    }

    protected function write(?string $str, string $color = 'b'): self
    {
        $map = [
            'r'  => ['red', 'black'],
            'b'  => ['blue', 'white'],
            'y'  => ['yellow', 'black'],
            'g'  => ['green', 'black'],
            'gr' => ['gray', 'black'],
            'w'  => ['white', 'black'],
            'c'  => ['cyan', 'white'],
        ];
        [$c, $bg] = $map[$color] ?? current($map);
        $str = $str ?: '';
        $this->line("<fg=$c;bg=$bg>$str</>");
        return $this;
    }
}
