<x-app-layout>
   

    <div class="checkout-container">
        <img src="{{ asset('https://i.pinimg.com/564x/cb/10/a8/cb10a8c996e4833058a9acbf61a68edf.jpg') }}" alt="Empty Cart">
        <h3>Add your Delivery Details</h3>
        <div class="container mt-4">
            <!-- Display success message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        <!-- Checkout Options -->
        <div class="row mb-4">
            <div class="col-md-4 text-center">
            
                <button class="btn btn-primary" id="ride-btn">Ride</button>
            </div>
            <div class="col-md-4 text-center">
                <button class="btn btn-primary" id="pickup-point-btn">Pickup Point</button>
            </div>
            <div class="col-md-4 text-center">
                <button class="btn btn-primary" id="past-nairobi-btn">Past Nairobi</button>
            </div>
        </div>
      

        <!-- Ride Form -->
        <div id="ride-form" class="form-container" style="display: none;">
            <h3>Ride Details</h3>
            <form method="POST" action="{{ route('submit') }}">
                @csrf
                <div class="form-group">
                    <label for="ride-name">Name</label>
                    <input type="text" id="ride-name" name="ride_name" class="form-control" required>
                   
                </div>
                <div class="form-group">
                    <label for="ride-area">Area</label>
                    <input type="text" id="ride-area" name="ride_area" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="ride-neighborhood">Neighborhood</label>
                    <input type="text" id="ride-neighborhood" name="ride_neighborhood" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="ride-apartment">Apartment</label>
                    <input type="text" id="ride-apartment" name="ride_apartment" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="ride-destination">Destination</label>
                    <input type="text" id="ride-destination" name="ride_destination" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <!-- Pickup Point Form -->
        <div id="pickup-point-form" class="form-container" style="display: none;">
            <h3>Pickup Point Details</h3>
            <form method="POST" action="{{ route('submit') }}">
                @csrf
                <div class="form-group">
                    <label for="pickup-name">Name of User</label>
                    <input type="text" id="pickup-name" name="pickup_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="pickup-destination">Destination</label>
                    <input type="text" id="pickup-destination" name="pickup_destination" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <!-- Past Nairobi Form -->
        <div id="past-nairobi-form" class="form-container" style="display: none;">
            <h3>Past Nairobi Details</h3>
            <form method="POST" action="{{ route('submit') }}">
                @csrf
                <div class="form-group">
                    <label for="past-name">Full Name</label>
                    <input type="text" id="past-name" name="past_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="past-area">Area</label>
                    <input type="text" id="past-area" name="past_area" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="past-destination">Destination</label>
                    <input type="text" id="past-destination" name="past_destination" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <!-- Proceed Button -->
        <a href="{{ route('payment') }}" id="proceed-btn" class="proceed-btn">Proceed to Payment</a>

    </div>

    <script>
//         document.getElementById('pickup-point-form').addEventListener('submit', function() {
//     console.log('Ride form submitted:', {
//         name: document.getElementById('pickup-name').value,
//         name: document.getElementById('pickup_destination').value,
//         // neighborhood: document.getElementById('ride-neighborhood').value,
//         // apartment: document.getElementById('ride-apartment').value,
//         // destination: document.getElementById('ride-destination').value,
//     });
// });

        document.getElementById('ride-btn').addEventListener('click', function() {
            document.getElementById('ride-form').style.display = 'block';
            document.getElementById('pickup-point-form').style.display = 'none';
            document.getElementById('past-nairobi-form').style.display = 'none';
          
        });

        document.getElementById('pickup-point-btn').addEventListener('click', function() {
            document.getElementById('ride-form').style.display = 'none';
            document.getElementById('pickup-point-form').style.display = 'block';
            document.getElementById('past-nairobi-form').style.display = 'none';
          
        });

        document.getElementById('past-nairobi-btn').addEventListener('click', function() {
            document.getElementById('ride-form').style.display = 'none';
            document.getElementById('pickup-point-form').style.display = 'none';
            document.getElementById('past-nairobi-form').style.display = 'block';
       
        });

    //     document.getElementById('proceed-btn').addEventListener('click', function(event) {
    //     // Get the values of the forms
    //     const rideName = document.getElementById('ride-name') ? document.getElementById('ride-name').value : '';
    //     const pickupName = document.getElementById('pickup-name') ? document.getElementById('pickup-name').value : '';
    //     const pastName = document.getElementById('past-name') ? document.getElementById('past-name').value : '';

    //     // Check if any of the forms have been filled
    //     if (!rideName && !pickupName && !pastName) {
    //         // Prevent proceeding to payment
    //         event.preventDefault();
    //         // Show alert message
    //         alert('Please add your delivery details to proceed to payment.');
    //     }
    // });

    </script>
     <style>
        .checkout-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .checkout-container img {
            display: block;
            margin: 20px auto;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .checkout-container h3 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .checkout-container .btn-primary {
            background-color: #007bff;
            color: #fff;
            margin: 10px;
            width: 180px;
        }

        .form-container {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: bold;
            margin-top: 10px;
        }

        .form-group input {
            margin-bottom: 15px;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
            width: 150px;
        }

        .proceed-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #17a2b8;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .proceed-btn:hover {
            background-color: #138f9d;
        }
    </style>
</x-app-layout>
