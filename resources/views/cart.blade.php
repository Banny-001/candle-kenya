
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(' Cart') }}
        </h2>
    </x-slot>

    <!-- Cart Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="row">
                @if($cartItems->isEmpty())
                    <!-- Empty Cart Section -->
                    <div class="col-md-12 text-center">
                        <h1 class="font-weight-bold">Your cart is empty!!</h1>
                        <img src="{{ asset('https://i.pinimg.com/564x/c4/ad/08/c4ad08fd8d70b7ad9272a5045d94ccbd.jpg') }}" alt="Empty Cart" class="animated-image">
                      
                    </div>
        
                    
                @else
            <div class="">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product</th>
                           
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cartItems as $item)
                            <tr>
                               
                                <td>
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>{{ $item->product->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary update-cart" data-id="{{ $item->product_id }}" data-quantity="{{ $item->quantity - 1 }}">-</button>
                                    <span>{{ $item->quantity }}</span>
                                    <button class="btn btn-sm btn-secondary update-cart" data-id="{{ $item->product_id }}" data-quantity="{{ $item->quantity + 1 }}">+</button>
                                </td>
                                <td>Ksh{{ number_format($item->product->amount* $item->quantity, 2) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-from-cart" data-id="{{ $item->product_id }}">Remove</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Your cart is empty</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <h3>Cart Summary</h3>
                <p>Total Items: <span id="cart-total">{{ $totalItems }}</span></p>
                <p>Total Amount: <strong>Ksh{{ number_format($totalAmount, 2) }}</strong></p>

                <a href="{{ route('checkout') }}" class="btn btn-primary block " >Proceed to Checkout</a>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Update Cart Quantity
        document.querySelectorAll('.update-cart').forEach(button => {
            button.addEventListener('click', function () {
                let productId = this.getAttribute('data-id');
                let newQuantity = this.getAttribute('data-quantity');

                if (newQuantity < 1) {
                    alert("Quantity can't be less than 1");
                    return;
                }

                fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: newQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();  // Reload to reflect changes
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // Remove Item from Cart
        document.querySelectorAll('.delete-from-cart').forEach(button => {
            button.addEventListener('click', function () {
                let productId = this.getAttribute('data-id');

                fetch('{{ route('cart.delete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();  // Reload to reflect changes
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
     <style>
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-30px);
            }
            60% {
                transform: translateY(-15px);
            }
        }

        .animated-image {
            width: 350px;
            height: 350px;
            display: block;
            margin: 0 auto;
            animation: bounce 2s infinite;
            background-color: transparent;
        }

        .font-weight-bold {
            font-weight: bold;
        }
    </style>
</x-app-layout>
