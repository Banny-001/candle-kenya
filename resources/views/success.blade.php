
<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <div class="bg-green-500 text-white text-center rounded-t-lg py-4">
                <h2 class="text-2xl font-bold">Payment Successful!</h2>
            </div>
            <div class="p-6 text-center">
                <h5 class="text-xl font-semibold mb-4">Thank You for Your Purchase!</h5>
                <p class="text-gray-700 mb-6">
                    Your order has been successfully processed. We appreciate your business!
                </p>
                <a href="{{ route('dashboard') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</x-app-layout>


