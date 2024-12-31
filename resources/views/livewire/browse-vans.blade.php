<div>
    <div class="w-full bg-blue-200 flex flex-wrap justify-center gap-2 mt-8 p-2">
        @foreach ($vans as $van)
            <div class=" bg-slate-200 p-8">
                <div class="image-container mx-auto mb-2">
                    <img src="https://placehold.co/300x400" alt="">
                </div>
                <h2 class="text-lg font-semibold">{{ $van->model }}</h2>
                <p class="text-sm">Capacity: {{ $van->capacity }}</p>
                <p class="text-sm">Rental Rate: RM{{ number_format($van->rental_rate, 2) }}</p>
                <button 
                    wire:click="selectVan({{ $van->id }})" 
                    class="bg-blue-500 text-white px-4 py-2 mt-2 rounded">
                    Book Now
                </button>
            </div>
        @endforeach
    </div>

    <!-- Registration Popup -->
    <div x-data="{ show: false }" @show-register-popup.window="show = true">
        <div x-show="show" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg">
                <h2 class="text-lg font-semibold">Register to Proceed</h2>
                <p>Please create an account to book this van.</p>
                <a href="{{ route('register') }}" class="bg-green-500 text-white px-4 py-2 mt-4 rounded">Register Now</a>
                <button @click="show = false" class="text-red-500 mt-4">Close</button>
            </div>
        </div>
    </div>
</div>
