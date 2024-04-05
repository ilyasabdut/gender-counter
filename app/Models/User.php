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

        static::deleted(function ($model) {

            $queryUser = User::whereDate('created_at', $model->created_at->toDateString())
                    ->whereNull('deleted_at')
                    ->get();

            [$male, $female] = $queryUser->partition(function($item){
                return $item->gender == 'male';
            });

            $maleAvgAge = (int) floor($male->avg('age'));
    
            $femaleAvgAge = (int) floor($female->avg('age'));

            $dailyRecord = DailyRecord::whereDate('date', $model->created_at->toDateString())->first();
            if($model->gender == 'male'){
                $dailyRecord->male_count = $dailyRecord->male_count - 1;
            }elseif($model->gender == 'female'){
                $dailyRecord->female_count = $dailyRecord->female_count - 1;
            }
            
            $dailyRecord->save();

        });
    }

}
