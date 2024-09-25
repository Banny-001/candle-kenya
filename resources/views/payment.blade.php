<x-app-layout>
    <div class="container mt-5">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white text-center py-4">
                <h3 class="m-0">Payment Details</h3>
            </div>
            <div class="card-body p-4">
                <!-- User Details -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5><strong>Name:</strong> {{ $user->name }}</h5>
                    </div>
                    <div class="col-md-6">
                        @if(session('delivery_type') == 'ride')
                            <p><strong>Ride Destination:</strong> {{ $deliveryDetails['ride_destination'] ?? 'Not provided' }}</p>
                        @elseif(session('delivery_type') == 'pickup_point')
                            <p><strong>Pickup Point:</strong> {{ $deliveryDetails['pickup_destination'] ?? 'Not provided' }}</p>
                        @elseif(session('delivery_type') == 'past_nairobi')
                            <p><strong>Past Nairobi Destination:</strong> {{ $deliveryDetails['past_destination'] ?? 'Not provided' }}</p>
                        @else
                            <p><strong>Delivery Details:</strong> Not available</p>
                        @endif
                    </div>
                </div>

                <!-- Cost Details -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Product Cost:</strong> Ksh {{ number_format($productCost, 2) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Delivery Cost:</strong> Ksh {{ number_format($deliveryCost, 2) }}</p>
                    </div>
                </div>

                <!-- Total Amount (centered) -->
                <div class="row mb-4">
                    <div class="col-md-12 text-center">
                        <h4 class="text-success"><strong>Total Amount:</strong> Ksh {{ number_format($totalAmount, 2) }}</h4>
                    </div>
                </div>

                <!-- KCB Paybill Payment Form -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="mb-3">KCB Paybill Payment</h5>
                        <div class="alert alert-info">
                            <p><strong>Follow these steps to complete your payment:</strong></p>
                            <ol class="pl-3 mb-0">
                                <li>Open your mobile money app (e.g., MPesa).</li>
                                <li>Go to <strong>Lipa na MPesa</strong> and select <strong>Paybill</strong>.</li>
                                <li>Enter the KCB Paybill number: <strong>522522</strong>.</li>
                                <li>Enter your account number as your <strong>Name</strong>.</li>
                                <li>Enter the total amount: <strong>Ksh {{ $totalAmount }}</strong>.</li>
                                <li>Complete the payment and come back to this page to confirm.</li>
                            </ol>
                        </div>
                        <form id="paymentForm" method="POST" action="{{ route('payment.confirm') }}">
                            @csrf
                            <div class="form-group">
                                <label for="phone-number">Enter Phone Number</label>
                                <input type="text" id="phone-number" name="phone_number" class="form-control"
                                       placeholder="07xx xxx xxx" required>
                            </div>
                            <div class="form-group">
                                <label for="mpesa-code">Enter MPesa Transaction Code</label>
                                <input type="text" id="mpesa-code" name="mpesa_code" class="form-control"
                                       placeholder="Transaction code (e.g., ABC12345)" required>
                            </div>
                            <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">
                            <button type="submit" class="btn btn-success btn-lg mt-3 w-100">Confirm Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Snackbar for Payment Processing -->
        <div id="snackbar" class="snackbar">Processing your payment...</div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div id="successSnackbar" class="snackbar success">
                {{ session('success') }}
                <p>Thank you for your purchase! Your order will be processed shortly.</p>
                <p>If you have any questions, feel free to <a href="{{ route('contact') }}">contact us</a>.</p>
            </div>
        @elseif(session('error'))
            <div id="errorSnackbar" class="snackbar error">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <style>
        .card-header {
            background-color: #4a90e2; /* Blue color for the header */
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-success {
            background-color: #4caf50;
            border: none;
            font-size: 1.1rem;
            transition: background-color 0.3s;
        }

        .btn-success:hover {
            background-color: #45a049;
        }

        #snackbar, .snackbar {
            visibility: hidden;
            min-width: 280px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            transform: translateX(-50%);
            top: 20px;
            font-size: 17px;
            opacity: 0;
            transition: opacity 0.5s, visibility 0.5s;
        }

        .snackbar.success {
            background-color: #4caf50;
        }

        .snackbar.error {
            background-color: #f44336;
        }

        .snackbar.show {
            visibility: visible;
            opacity: 1;
        }

        .alert-info {
            background-color: #e9f7fe;
            color: #31708f;
            border: 1px solid #bcdff1;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>

    <script>
        document.getElementById('paymentForm').addEventListener('submit', function (e) {
            var snackbar = document.getElementById('snackbar');
            snackbar.classList.add("show");
            setTimeout(function () {
                snackbar.classList.remove("show");
            }, 3000);
        });

        window.onload = function () {
            var successSnackbar = document.getElementById('successSnackbar');
            var errorSnackbar = document.getElementById('errorSnackbar');

            if (successSnackbar) {
                successSnackbar.classList.add('show');
                setTimeout(function () {
                    successSnackbar.classList.remove('show');
                }, 5000);
            }

            if (errorSnackbar) {
                errorSnackbar.classList.add('show');
                setTimeout(function () {
                    errorSnackbar.classList.remove('show');
                }, 5000);
            }
        };
    </script>
</x-app-layout>
