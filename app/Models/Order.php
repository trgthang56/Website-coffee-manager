<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
       
         'user_id',
        'table_id',
        'mess',
        'status',
        'payBy',
        'price',
        'total',
        'payMethod',
        'code',
        'discount',
     
       
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')
            ->withDefault(['name' => '']);
    }
    public function voucher()
    {
        return $this->hasOne(Voucher::class, 'id', 'code');
    }
    public function userPay()
    {
        return $this->hasOne(User::class, 'id', 'payBy')
            ->withDefault(['name' => '']);
    }
    public function table()
    {
        return $this->hasOne(Table::class, 'id', 'table_id')
            ->withDefault(['name' => '']);
    }

    public function OrderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }
}
