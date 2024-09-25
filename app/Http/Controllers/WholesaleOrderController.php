<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WholesaleOrder; 

class WholesaleOrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'event' => 'required|integer',
            'message' => 'nullable|string',
        ]);

        // Save to the database
        WholesaleOrder::create($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Order submitted successfully!');
    }
}
