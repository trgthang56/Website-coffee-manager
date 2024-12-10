<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'value',
        'expiry_date',
        'user_role',
        'status',
        'condition',
        'image',
        'user_id'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')
            ->withDefault(['name' => '']);
    }
}
