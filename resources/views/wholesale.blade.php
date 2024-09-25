<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Wholesale Orders') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('wholesale.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" name="phone" class="form-control" id="phone" placeholder="07xxxxxxx" required>
            </div>
            <div class="mb-3">
                <label for="event" class="form-label">Event</label>
                <select name="event" class="form-select" id="event" required>
                    <option value="" disabled selected>Select an event</option>
                    <option value="1">Baby Shower</option>
                    <option value="2">Bridal Shower</option>
                    <option value="3">Birthday</option>
                    <option value="3">Anniversary</option>
                    <option value="3">House Warming</option>
                    <option value="3">Valentines Day</option>
                    <option value="3">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea name="message" class="form-control" id="message" rows="3" placeholder="Enter your message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Order</button>
        </form>
    </div>

    <style>
        .container {
            max-width: 600px; /* Set max width for the form */
            margin: auto; /* Center the container */
            padding: 20px; /* Add padding to the container */
            background-color: rgba(255, 255, 255, 0.9); /* Light background for readability */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }
    </style>
</x-app-layout>
