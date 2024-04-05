<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyRecord extends BaseModel
{
    use HasFactory;

    protected $table = 'dailyRecords';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    //  public static function boot()
    //  {
    //      parent::boot();
 
    //      static::updated(function ($dailyRecord) {
    //         try{
    //             if ($dailyRecord->isDirty('male_count') || $dailyRecord->isDirty('female_count')) {
    //                 $maleAvgAge = User::where('gender', 'male')->avg('age');
    //                 $femaleAvgAge = User::where('gender', 'female')->avg('age');
                   
    //                 // $dailyRecord->update([
    //                 //     'male_avg_age' => (int)floor($maleAvgAge),
    //                 //     'female_avg_age' => (int)floor($femaleAvgAge)
    //                 // ]);
    //                 $dailyRecord->male_avg_age = (int)floor($maleAvgAge);
    //                 $dailyRecord->female_avg_age = (int)floor($femaleAvgAge);
    //                 $dailyRecord->save();
    //             }
    //         }catch(\Exception $e){
    //             throw $e;
    //         }
    //      });
    //  }
 
}
