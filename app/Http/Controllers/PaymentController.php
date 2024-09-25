<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Checkout;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class PaymentController extends Controller
{
    public function showPaymentPage()
    {
        $user = Auth::user();

        // Retrieve delivery details from session (set during checkout)
        $deliveryType = session('delivery_type');
        $deliveryDetails = session('checkout_location'); // Assuming this stores delivery info

        // Get cart items for the logged-in user
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        // Calculate product cost
        $productCost = $cartItems->sum(function ($item) {
            return $item->product->amount * $item->quantity;
        });
        // Calculate delivery cost based on the delivery type
        $deliveryCost = 0;
        switch ($deliveryType) {
            case 'ride':
                $deliveryCost = 350; // Ride delivery cost
                break;
            case 'pickup_point':
                $deliveryCost = 0; // No delivery fee for pickup
                break;
            case 'past_nairobi':
                $deliveryCost = 400; // Delivery fee for past Nairobi
                break;
            default:
                $deliveryCost = 0; // Default case if no valid delivery type
                break;
        }
        // Calculate total amount (product cost + delivery cost)
        $totalAmount = $productCost + $deliveryCost;

        return view('payment', compact('user', 'deliveryDetails', 'productCost', 'deliveryCost', 'totalAmount'));
    }


    public function processPayment(Request $request)
    {
        // Validate the request
        $request->validate([
            'mpesa_number' => 'required|string|digits:10',
        ]);

        // Fetch the latest checkout record for the logged-in user
        $checkout = Checkout::where('user_id', Auth::id())->latest()->first();

        if ($checkout) {
            // Get cart items and calculate total price
            $cartItems = Cart::where('user_id', Auth::id())->get();
            $productCost = $cartItems->sum(function ($item) {
                return $item->product->amount * $item->quantity;
            });
            // Get delivery details and delivery cost from the checkout data
            $deliveryCost = $checkout->delivery_cost; // Assuming this field is in the checkout table
            $totalAmount = $productCost + $deliveryCost;
            // Clear the cart after payment
            Cart::where('user_id', Auth::id())->delete();

            // Initiate MPesa payment
            $paymentResponse = $this->initiatePayment($request->mpesa_number, $totalAmount);

            if (isset($paymentResponse['ResponseCode']) && $paymentResponse['ResponseCode'] == '0') {
                return redirect()->back()->with('success', 'Payment successful! Thank you for your purchase.');
            } else {
                return redirect()->back()->with('error', 'Payment failed. Please try again.');
            }
        } else {
            return redirect()->back()->with('error', 'No checkout details found. Please complete the checkout process.');
        }
    }

    private function initiatePayment($mpesaNumber, $totalAmount)
    {
        // M-Pesa credentials
        $consumerKey = env('MPESA_CONSUMER_KEY');
        $consumerSecret = env('MPESA_CONSUMER_SECRET');
        $shortcode = env('MPESA_SHORTCODE');
        $lipaNaMpesaOnline = '174379';

        // Step 1: Get the access token
        $url = env('MPESA_ENV') == 0
            ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init($url);
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf8'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => "$consumerKey:$consumerSecret",
            )
        );
        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        if (!isset($response->access_token)) {
            Log::error('Failed to retrieve access token');
            return redirect()->back()->with('error', 'Failed to initiate payment. Please try again.');
        }

        $accessToken = $response->access_token;

        // Step 2: Prepare the STK Push request
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($shortcode . env('MPESA_PASSKEY') . $timestamp);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
            'BusinessShortCode' => $lipaNaMpesaOnline,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $totalAmount,
            'PartyA' => $mpesaNumber,
            'PartyB' => $lipaNaMpesaOnline,
            'PhoneNumber' => $mpesaNumber,
            'CallBackURL' => route('payment.callback'),
            'AccountReference' => 'YourAccountReference',
            'TransactionDesc' => 'Payment for order',
        ]);

        Log::info('M-Pesa STK Push Response', $response->json());

        return $response->json();
    }
    public function simulateTransaction(Request $request)
    {
        $body = array(
            'ShortCode' => env('MPESA_SHORTCODE'),
            'Msisdn' => ' 254708729680',
            'Amount' => $request->amount,
            'BillRefNumber' => $request->account,
            'CommandID' => 'CustomerPayBillOnline'
        );

        $url =  '/c2b/v1/simulate';
        $response = $this->makeHttp($url, $body);
        //  Log::info($response);
        Log::info('M-Pesa Payment Callback', $request->all());
        return $response;
    }

    public function makeHttp($url, $body)
    {
        // $url = 'https://mpesa-reflector.herokuapp.com' . $url;
        $url = 'https://sandbox.safaricom.co.ke/mpesa/' . $url;
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization:Bearer ' . $this->getAccessToken()),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($body)
            )
        );
        $curl_response = curl_exec($curl);
        curl_close($curl);
        Log::info($curl_response);
        return $curl_response;
    }


    //using kcb paybill 


    public function confirmPayment(Request $request)
    {
        // Validate the MPesa transaction code
        $request->validate([
             'mpesa_code' => 'required|string|max:50',
            'totalAmount' => 'required|numeric',
            //  'phone_number'=>'required|number|max:10',
            
        ]);
//         $mpesaCode = $request->input('mpesa_code');

      
// if (!preg_match('/^[A-Za-z0-9]{10}$/', $mpesaCode)) {
//     return back()->with('error', 'Invalid MPesa Transaction Code.');
// }
        // Fetch the latest checkout record for the logged-in user
        $checkout = Checkout::where('user_id', Auth::id())->latest()->first();

        if ($checkout) {
            // Create the order after successful payment confirmation
            $order = Order::create([
                'user_id' => Auth::id(),
                'checkout_id' => $checkout->id,
                'total_amount' => $request->input('totalAmount'),
                'payment_status' => 'Confirmed',
                'mpesa_code' => $request->input('mpesa_code'),
                'phone_number'=>$request->input('phone_number')
            ]);
            // Clear the cart after successful payment confirmation
            Cart::where('user_id', Auth::id())->delete();

            // Redirect back with a success message
            // return redirect()->route('payment.success')->with('success', 'Payment confirmed successfully! Your order has been placed.');
             return redirect()->route('payment.success');
        } else {
            return redirect()->back()->with('error', 'Checkout details not found. Please complete the checkout process.');
        }
    }
    public function paymentSuccess()
    {
        return view('success'); // Return the success view
    }
}
