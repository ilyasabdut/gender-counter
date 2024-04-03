<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends BaseModel
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'gender',
        'location',
        'age'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {

            $queryUser = User::whereNull('deleted_at')
            ->get();

            [$male, $female] = $queryUser->partition(function($item){
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
