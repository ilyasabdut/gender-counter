<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class SaveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:users';

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
        //Fetch random users
        $randomUsers = randomUser()->get('/api?results=20')->json('results');
        foreach($randomUsers as $key => $user){
            $counter = $key + 1;
            User::updateOrCreate(
            [
                'uuid' => $user['login']['uuid'],
            ],
            [
                'name' => json_encode($user['name']),
                'gender' => $user['gender'],
                'location' => json_encode($user['location']),
                'age' => $user['dob']['age'],
            ]);
            $this->output->writeln($counter . ' success inserting ' . $user['login']['uuid'], false);
        }

        $totalMale = User::where('gender', 'male')->count();
        $totalFemale = User::where('gender', 'female')->count();

        //Set total male and female into redis
        Redis::set('total_male', $totalMale);
        Redis::set('total_female', $totalFemale);

    }

}
