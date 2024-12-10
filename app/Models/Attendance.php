<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'work_date',
        'total_hours',
        'status',
        'check_in_time',
        'check_out_time',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')
            ->withDefault(['name' => '']);
    }
}
