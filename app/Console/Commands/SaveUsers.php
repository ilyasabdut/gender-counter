<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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

    }

}
