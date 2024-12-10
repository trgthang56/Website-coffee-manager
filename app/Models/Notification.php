<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'content',
        'read_by'    
    ];
    protected $casts = [
        'read_by' => 'json',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')
            ->withDefault(['name' => '']);
    }
}
