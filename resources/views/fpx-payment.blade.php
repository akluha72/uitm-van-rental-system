<x-app-layout>
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-4 rounded-lg shadow-lg w-3/4 mx-auto">
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">FPX Payment</h1>
    
            @if (session('status'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
                    {{ session('status') }}
                </div>
            @endif
    
            <form action="{{ route('fpx.process') }}" method="POST" class="space-y-4 flex flex-col">
                @csrf
                <div>
                    <label for="amount" class="block text-gray-700 font-medium mb-2">Payment Amount</label>
                    <input type="number" name="amount" id="amount" required placeholder="Enter amount"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                </div>
    
                <div>
                    <label for="bank" class="block text-gray-700 font-medium mb-2">Select Bank</label>
                    <select name="bank" id="bank" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                        <option value="" disabled selected>Select a bank</option>
                        <option value="maybank">Maybank</option>
                        <option value="cimb">CIMB</option>
                        <option value="publicbank">Public Bank</option>
                        <option value="rhb">RHB</option>
                    </select>
                </div>
    
                <button type="submit"
                        class="ml-auto mt-4 bg-blue-500 text-white p-3 rounded-lg font-medium hover:bg-blue-600 transition">
                    Proceed to Payment
                </button>
            </form>
        </div>
    </div>
</x-app-layout>