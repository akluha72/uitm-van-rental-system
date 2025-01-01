<div>
    <div class="w-full flex flex-wrap justify-center gap-2 mt-8 p-2">
        @foreach ($vans as $van)
            <div class=" bg-slate-200 p-4 m-2">
                <div class="image-container mx-auto mb-2">
                    <img src="https://placehold.co/300x400" alt="">
                </div>
                <h2 class="text-lg font-semibold">{{ $van->model }}</h2>
                <p class="text-sm">Seats: {{ $van->capacity }}</p>
                <p class="text-sm">Rental Rate: RM{{ number_format($van->rental_rate, 2) }} per day</p>
                <button wire:click="selectVan({{ $van->id }})"
                    class="bg-blue-500 text-white px-4 py-2 mt-2 mr-auto rounded">
                    Book Now
                </button>
            </div>
        @endforeach
    </div>


    <!-- Booking Form Modal -->
    @if ($showBookingForm)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg w-1/2">
                <h2 class="text-xl font-semibold mb-4">Book {{ $selectedVan->model }}</h2>

                <!-- Van Details -->
                <div class="mb-4 flex flex-row relative">
                    <!-- Image at the back -->
                    <div class="booking-popup-image absolute inset-0 z-0">
                        <img src="https://placehold.co/700x200" alt="Van Image" class="h-64 w-full object-cover">
                    </div>

                    <!-- Gradient Layer -->
                    <div class="relative bg-gradient-to-r from-black to-transparent h-64 w-[80%] z-10">
                        <!-- This gradient will cover 30% of the image -->
                    </div>

                    <!-- Description Layer -->
                    <div class="booking-popup-description absolute left-2 z-20 h-full p-4 rounded">
                        <p class="text-sm text-white"><strong>Model:</strong> {{ $selectedVan->model }}</p>
                        <p class="text-sm text-white"><strong>Capacity:</strong> {{ $selectedVan->capacity }} passengers
                        </p>
                        <p class="text-sm text-white"><strong>Rental Rate:</strong>
                            RM{{ number_format($selectedVan->rental_rate, 2) }} per day</p>
                        <p class="text-sm text-white"><strong>License Plate:</strong> {{ $selectedVan->license_plate }}
                        </p>
                    </div>
                </div>

                {{-- <form wire:submit.prevent="bookVan">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Your Name</label>
                        <input type="text" wire:model="name" class="w-full border-gray-300 rounded p-2"
                            placeholder="Enter your name">
                    </div>
                    <div class="flex flex-row items-center gap-2 mb-4">
                        <!-- Start Date -->
                        <div class="">
                            <label class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" wire:model="startDate" class="w-full border-gray-300 rounded p-2">
                        </div>

                        <!-- 'to' Text -->
                        <p class="text-gray-700 mt-5">to</p>

                        <!-- End Date -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" wire:model="endDate" class="w-full border-gray-300 rounded p-2">
                        </div>
                    </div>

                    <div class="upload-license-pdf bg-gray-100 p-4 rounded-lg w-full max-w-sm mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload License PDF
                        </label>
                        <div
                            class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-4">
                            <label for="license-upload" class="flex flex-col items-center cursor-pointer">
                                <span class="text-gray-500 text-sm mb-1">Click to upload your license (PDF only)</span>
                                <input id="license-upload" type="file" wire:model="license" accept="application/pdf"
                                    class="hidden">
                            </label>
                        </div>
                    </div>
                    <h1>{{ $this->termsAccepted }}</h1>


                    <div class="mb-4">
                        <input type="checkbox" id="terms" wire:model="termsAccepted" class="mr-2">
                        <label for="terms" class="text-sm text-gray-700">
                            I agree to the <a href="#" class="text-blue-500 underline">Terms and Conditions</a>
                            and
                            <a href="#" class="text-blue-500 underline">Privacy Policy</a>.
                        </label>
                    </div>

                    <div class="form-button relative ml-auto">
                        @if (!$termsAccepted)
                            <button type="submit" class="px-4 py-2 rounded text-white bg-slate-500 cursor-not-allowed">
                                Confirm Booking
                            </button>
                        @else
                            <button type="submit" class="px-4 py-2 rounded text-white bg-green-500">
                                Confirm Booking
                            </button>
                        @endif
                        <button type="button" wire:click="closeBookingForm"
                            class="bg-red-500 text-white px-4 py-2 rounded ml-2">
                            Cancel
                        </button>
                    </div>
                </form> --}}

                <div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Your Name</label>
                        <input type="text" wire:model="name" class="w-full border-gray-300 rounded p-2"
                            placeholder="Enter your name">
                    </div>
                    <div class="flex flex-row items-center gap-2 mb-4">
                        <!-- Start Date -->
                        <div class="">
                            <label class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" wire:model="startDate" class="w-full border-gray-300 rounded p-2">
                        </div>

                        <!-- 'to' Text -->
                        <p class="text-gray-700 mt-5">to</p>

                        <!-- End Date -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" wire:model="endDate" class="w-full border-gray-300 rounded p-2">
                        </div>
                    </div>

                    <div class="upload-license-pdf bg-gray-100 p-4 rounded-lg w-full max-w-sm mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload License PDF
                        </label>
                        <div
                            class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-4">
                            <label for="license-upload" class="flex flex-col items-center cursor-pointer">
                                <span class="text-gray-500 text-sm mb-1">Click to upload your license (PDF only)</span>
                                <input id="license-upload" type="file" wire:model="license" accept="application/pdf"
                                    class="hidden">
                            </label>
                        </div>
                    </div>

              

                    <div class="mb-4">
                        <input type="checkbox" id="terms" wire:click="toggleTermsAccepted" class="mr-2">
                        <label for="terms" class="text-sm text-gray-700">
                            I agree to the <a href="#" class="text-blue-500 underline">Terms and Conditions</a>
                            and
                            <a href="#" class="text-blue-500 underline">Privacy Policy</a>.
                        </label>
                    </div>

                    <h1>{{ $this->termsAccepted }}</h1>

                    <div class="form-button relative ml-auto">
                        @if (!$termsAccepted)
                            <button type="button" wire:click.prevent="bookVan"
                                class="px-4 py-2 rounded text-white bg-slate-500 cursor-not-allowed" disabled>
                                Confirm Booking
                            </button>
                        @else
                            <button type="button" wire:click="bookVan"
                                class="px-4 py-2 rounded text-white bg-green-500">
                                Confirm Booking
                            </button>
                        @endif
                        <button type="button" wire:click="closeBookingForm"
                            class="bg-red-500 text-white px-4 py-2 rounded ml-2">
                            Cancel
                        </button>
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>
