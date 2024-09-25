<x-app-layout>
    <x-slot name="header">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary" onclick="filterProducts('all')">All</button>
            <button type="button" class="btn btn-outline-primary" onclick="filterProducts('candles')">Candles</button>
            <button type="button" class="btn btn-outline-primary" onclick="filterProducts('tea-lights')">Tea Lights</button>
            <button type="button" class="btn btn-outline-primary" onclick="filterProducts('diffuser')">Diffusers</button>
            <button type="button" class="btn btn-outline-primary" onclick="filterProducts('carscent')">Car Scents</button>
            <button type="button" class="btn btn-outline-primary" onclick="filterProducts('room-sprays')">Room Sprays</button>
        </div>
    </x-slot>

    <!-- Products Section -->
    <div class="container mt-4">
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 product-card mb-4" data-category="{{ $product->category }}">
                    <div class="card rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300" style="background-color: rgba(255, 255, 255, 0.8);">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <h5 class="card-title">Ksh:{{ $product->amount }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <button class="btn btn-primary add-to-cart" data-id="{{ $product->id }}">Add to cart</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function filterProducts(category) {
            const productCards = document.querySelectorAll('.product-card');

            productCards.forEach(card => {
                const productCategory = card.getAttribute('data-category');

                if (category === 'all' || category === productCategory) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Add to Cart
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function () {
                let productId = this.getAttribute('data-id');

                fetch('{{ route('cart.add') }}', {
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
                    updateCartTotal();
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // Update cart total
        function updateCartTotal() {
            fetch('{{ route('cart.total') }}')
            .then(response => response.json())
            .then(data => {
                // Assuming you have a cart total display somewhere
                document.getElementById('cart-total').innerText = `Total Items: ${data.total}`;
            });
        }
    </script>

    <style>
        .product-card {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .card {
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</x-app-layout>
