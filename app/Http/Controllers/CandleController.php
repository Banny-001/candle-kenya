<?php

namespace App\Http\Controllers;
use App\Models\Product;


use Illuminate\Http\Request;

class CandleController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Assume products have a category column
        return view('shop', compact('products'));
    }

}
