<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diffuser extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'amount',
        'image'
    ];
}
