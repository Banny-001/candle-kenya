<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',   'ride_name', 'ride_area', 'ride_neighborhood', 'ride_apartment', 'ride_destination',
        'pickup_name', 'pickup_destination',
        'past_name', 'past_area', 'past_destination'
    ];
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
