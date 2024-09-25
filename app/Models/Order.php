<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'checkout_id', 
        'total_amount', 
        'payment_status', 
        'mpesa_code', 
        'phone_number'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }
}
