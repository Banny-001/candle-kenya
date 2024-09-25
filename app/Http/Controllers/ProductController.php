<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Get the category from the request, or default to 'all'
        $category = $request->input('category', 'all');
        
        // Filter products based on category if not 'all'
        if ($category === 'all') {
            $products = Product::all();
        } else {
            $products = Product::where('category', $category)->get();
        }

        // Pass products to the view
        return view('shop', compact('products'));
    }
}
