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
}
