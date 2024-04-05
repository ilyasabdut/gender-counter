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
        [$male, $female] = User::whereDate('created_at', now()->toDateString())
                            ->get()->partition(function($item){
                                return $item->gender == 'male';
                            });

        $maleCount = is_null(Redis::get('total_male')) ? $male->count() : Redis::get('total_male');
        $femaleCount = is_null(Redis::get('total_female')) ? $female->count() : Redis::get('total_female');
    
        $maleAvgAge = (int) floor($male->avg('age'));
    
        $femaleAvgAge = (int) floor($female->avg('age'));

        DailyRecord::create([
            'date' => now()->toDateTimeString(),
            'male_count' => $maleCount,
            'female_count' => $femaleCount,
            'male_avg_age' => $maleAvgAge,
            'female_avg_age' => $femaleAvgAge
        ]);
    }
    }
