
<x-app-layout>
    <div class="bg-cover bg-center h-60" style="background-image: url('https://i.pinimg.com/736x/e5/20/10/e52010a2bb3be41f8930d0ee0d30e3da.jpg'); height:100vh">
        <div class="flex flex-col items-center justify-center h-full bg-black bg-opacity-50">
            <h1 class="text-white text-4xl md:text-5xl font-bold mb-6">A Taste of Scent</h1>
    
            <!-- Shop Now Button -->
            <a href="/shop" class="animated-button text-black font-bold py-3 px-8 rounded-full border-2 border-white transition-all duration-500 ease-in-out hover:bg-white hover:text-black">
                Shop Now
            </a>
        </div>
    </div>
    

    <div class="py-12">
        <h2 class="text-3xl font-bold text-center mb-8">Our Collections</h2>
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $collections = [
                    [
                        'title' => 'Holiday Collection',
                        'description' => "Bunny Scents' Holiday Collection offers a magical array of Christmas and festival-themed candles, enchanting your home with festive cheer. From cozy winter nights to joyful celebrations, ignite your holiday spirit with our exquisite scents.",
                        'image' => 'https://i.pinimg.com/564x/28/6f/98/286f98826295b5c0e59ec3f0483850d9.jpg'
                    ],
                    [
                        'title' => 'Floral Collection',
                        'description' => "Immerse yourself in the beauty of Bunny Scents' Floral Collection. Inspired by gardens in full bloom, our floral-scented candles will fill your space with the refreshing and romantic essence of flowers.",
                        'image' => 'https://i.pinimg.com/564x/33/b1/81/33b181e1b8cbbf7dffc7f77571825c53.jpg'
                    ],
                    [
                        'title' => 'Car Scents',
                        'description' => "Take the freshness with you! Bunny Scents' Car Scents are specially designed to keep your car smelling amazing with long-lasting fragrances that turn every drive into a refreshing journey.",
                        'image' => 'https://i.pinimg.com/564x/43/62/62/436262c8a6ea2b43005345731a422142.jpg'
                    ],
                    [
                        'title' => 'Tea Lights',
                        'description' => "Our Tea Lights Collection brings a soft, calming glow to any setting. Perfect for home décor, dinner settings, or relaxation, these small candles deliver big on ambiance and fragrance.",
                        'image' => 'https://i.pinimg.com/564x/6d/f3/cd/6df3cd6ca28e54fcf06d788f9ef0d723.jpg'
                    ],
                    [
                        'title' => 'Diffusers',
                        'description' => "Experience long-lasting aromas with Bunny Scents' Diffusers. These elegant diffusers provide continuous fragrance to your space, giving your home a welcoming, refreshing atmosphere.",
                        'image' => 'https://i.pinimg.com/736x/ec/6d/a2/ec6da24814fe7ef05afdb89019b8f72c.jpg'
                    ],
                    [
                        'title' => 'Room Sprays',
                        'description' => "Quick and effective! Our Room Sprays are the perfect solution for freshening up your space instantly with a burst of fragrance, keeping your environment clean and fragrant.",
                        'image' => 'https://i.pinimg.com/564x/4d/cf/5b/4dcf5b0311b1ab0db8a3c94631e667a4.jpg'
                    ]
                ];
            @endphp
    
            @foreach($collections as $index => $collection)
                <div class="card transform transition duration-500 hover:scale-105 shadow-lg">
                    <div class="flex flex-col md:flex-row g-0">
                        <div class="md:w-1/3">
                            <img src="{{ $collection['image'] }}" class="w-full h-full object-cover rounded-t-lg md:rounded-l-lg md:rounded-tr-none transition-transform duration-300 transform hover:scale-110" alt="{{ $collection['title'] }}">
                        </div>
                        <div class="md:w-2/3 p-4">
                            <h5 class="text-xl font-semibold">{{ $collection['title'] }}</h5>
                            <p class="text-gray-600 text-sm">{{ $collection['description'] }}</p>
                            <p class="text-gray-500 text-xs"><small>Last updated {{ now()->diffInMinutes(now()->subMinutes($index * 3)) }} mins ago</small></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    

    <div class="bg-cover bg-center h-60" style="background-image: url('https://i.pinimg.com/736x/e5/20/10/e52010a2bb3be41f8930d0ee0d30e3da.jpg'); height:40vh">
        <div class="h-full bg-black bg-opacity-50 flex flex-col items-center justify-center">
            <h1 class="text-white text-3xl font-bold mb-4">Burning Tips</h1>
            <ol class="list-decimal list-inside text-white text-left">
                <li class="mb-2">Keep wick trimmed to 1/4 inch.</li>
                <li class="mb-2">Avoid burning in drafty areas.</li>
                <li class="mb-2">Let the wax melt across the entire surface.</li>
                <li class="mb-2">Burn within sight, keep away from flammable objects,children and pets</li>
            </ol>
        </div>
    </div>
    <div class="max-w-7xl mx-auto mt-8">
        <div class="card transform transition duration-500 hover:scale-105 shadow-lg">
            <div class="flex flex-col md:flex-row g-0">
                <div class="md:w-1/3">
                    <img src="https://i.pinimg.com/564x/08/ea/51/08ea515dc468e747ed0834d784a32494.jpg" class="rounded-t-lg md:rounded-l-lg md:rounded-tr-none transition-transform duration-300 transform hover:scale-110" alt="About Us" style="height: 100%;">
                </div>
                <div class="md:w-2/3 p-4">
                    <h5 class="text-xl font-semibold mx-auto text-center">About Us</h5>
                    <p class="text-gray-600 mt-4 text-sm">We are dedicated to bringing you the finest scents for your home, car, and personal enjoyment. Our collections are crafted with care and designed to elevate your experience.</p>
                    <div class="max-w-7xl mx-auto mt-8 text-center">
                        <h5 class="text-xl font-semibold">Follow Us</h5>
                        <div class="flex justify-center mt-4">
                            <a href="https://www.instagram.com/scented_ke_/?hl=en#" class="mx-2" target="_blank">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" class="h-8 w-8">
                            </a>
                            <a href="https://www.facebook.com/yourprofile" class="mx-2" target="_blank">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" class="h-8 w-8">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
     
    </div>
    <footer class="bg-gray-800 text-white text-center p-4">
        <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
    </footer>

    {{-- <style>
        /* Card image hover effect */
        .card img {
            transition: transform 0.3s;
        }
    </style> --}}
</x-app-layout>
