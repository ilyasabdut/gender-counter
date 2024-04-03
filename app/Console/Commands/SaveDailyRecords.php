<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\DailyRecord;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class SaveDailyRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:daily-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        self::dailyRecords();
        $this->output->writeln('success inserting daily record at ' . now()->toDateTimeString(), false);
    }

    public function dailyRecords()
    {
        $maleCount = Redis::get('total_male');
        $femaleCount = Redis::get('total_female');
    
        $maleAvgAge = (int) floor(User::where('gender', 'male')->avg('age'));
    
        $femaleAvgAge = (int) floor(User::where('gender', 'female')->avg('age'));
    
        DailyRecord::create([
            'date' => now()->toDateTimeString(),
            'male_count' => $maleCount,
            'female_count' => $femaleCount,
            'male_avg_age' => $maleAvgAge,
            'female_avg_age' => $femaleAvgAge
        ]);
    }
    }
