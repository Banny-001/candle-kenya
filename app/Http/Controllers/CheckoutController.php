<?php

namespace App\Http\Controllers;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function submit(Request $request)
    {
    
        // Validation
        $request->validate([
            'ride_name' => 'nullable|string|max:255',
            'ride_area' => 'nullable|string|max:255',
            'ride_neighborhood' => 'nullable|string|max:255',
            'ride_apartment' => 'nullable|string|max:255',
            'ride_destination' => 'nullable|string|max:255',
            'pickup_name' => 'nullable|string|max:255',
            'pickup_destination' => 'nullable|string|max:255',
            'past_name' => 'nullable|string|max:255',
            'past_area' => 'nullable|string|max:255',
            'past_destination' => 'nullable|string|max:255',
            
           
        ]);
        
       

         // Determine the selected delivery type and cost
    $deliveryType = $request->input('delivery_type'); // This should come from your form
    $deliveryCost = 0;

    switch ($deliveryType) {
        case 'ride':
            $deliveryCost = 350;
            break;
        case 'pickup_point':
            $deliveryCost = 0; // or whatever the cost is
            break;
        case 'past_nairobi':
            $deliveryCost = 400;
            break;
         
    } 
    Checkout::create(array_merge($request->all(), [
        'user_id' => Auth::id(),
    ]));
    return redirect()->back()->with('success', 'Checkout details saved successfully!');
}
}