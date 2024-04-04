<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Redis;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends BaseModel
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {


            [$male, $female] = User::get()->partition(function($item){
                return $item->gender == 'male';
            });
    
            $maleAvgAge = (int) floor($male->avg('age'));
    
            $femaleAvgAge = (int) floor($female->avg('age'));

            $dailyRecord = DailyRecord::latest('created_at')->first();
            $dailyRecord->male_count = $male->count();
            $dailyRecord->female_count = $female->count();
            $dailyRecord->male_avg_age = $maleAvgAge;
            $dailyRecord->female_avg_age = $femaleAvgAge;
            $dailyRecord->save();

            //Set total male and female into redis
            Redis::set('total_male', $male->count());
            Redis::set('total_female', $female->count());


        });

        static::deleted(function ($model) {

            $queryUser = User::whereNull('deleted_at')->get();


            [$male, $female] = $queryUser->partition(function($item){
                return $item->gender == 'male';
            });

            $maleAvgAge = (int) floor($male->avg('age'));
    
            $femaleAvgAge = (int) floor($female->avg('age'));

            $dailyRecord = DailyRecord::latest('created_at')->first();
            if($model->gender == 'male'){
                $dailyRecord->male_count = $dailyRecord->male_count - 1;
            }elseif($model->gender == 'female'){
                $dailyRecord->female_count = $dailyRecord->female_count - 1;
            }
            $dailyRecord->male_avg_age = $maleAvgAge;
            $dailyRecord->female_avg_age = $femaleAvgAge;
            $dailyRecord->save();

        });
    }

}
