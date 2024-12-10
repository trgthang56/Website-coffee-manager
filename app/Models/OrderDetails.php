<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'product_id',
        'order_id',
        'price',
        'qty',     
        'mess',
        'status'
       
    ];
    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id')
            ->withDefault(['name' => '']);
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')
            ->withDefault(['name' => '']);
    }
}
