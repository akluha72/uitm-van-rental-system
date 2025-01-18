<x-app-layout>
    <div class="container mx-auto p-6 relative">
        <h1 class="text-2xl font-bold mb-4">Manage Vans</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Van Button -->
        <div class="flex justify-end mb-4">
            <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="openVanModal()">Add Van</button>
        </div>

        <!-- Vans Table -->
        <div class="overflow-x-auto">
            <table id="vansTable" class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Model</th>
                        <th class="border px-4 py-2">Plate Number</th>
                        <th class="border px-4 py-2">Seaters</th>
                        <th class="border px-4 py-2">Rate/day</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vans as $van)
                        <tr>
                            <td class="border px-4 py-2">{{ $van->model }}</td>
                            <td class="border px-4 py-2 text-black">{{ strtoupper($van->license_plate) }} </td>
                            <td class="border px-4 py-2">{{ $van->capacity }}</td>
                            <td class="border px-4 py-2">RM {{ $van->rental_rate }}</td>


                            <td class="border px-4 py-2">
                                <button class="bg-yellow-500 text-white px-2 py-1 rounded"
                                    onclick="editVan({{ $van->id }})">Edit</button>
                                <form action="{{ route('admin.vans.destroy', $van) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-2 py-1 rounded"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="vanModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-1/3 p-6 rounded shadow-lg">
            <h2 id="modalTitle" class="text-xl font-bold mb-4">Add Van</h2>
            <form id="vanForm" method="POST">
                @csrf
                <input type="hidden" id="method" name="_method">
                <div class="mb-4">
                    <label for="model" class="block font-bold mb-2">Model</label>
                    <input type="text" id="model" name="model" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="plate_number" class="block font-bold mb-2">Plate Number</label>
                    <input type="text" id="plate_number" name="license_plate" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="capacity" class="block font-bold mb-2">Capacity</label>
                    <input type="number" id="capacity" name="capacity" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="rate" class="block font-bold mb-2">Rental Rate /day</label>
                    <input type="number" id="rate" name="rental_rate" class="w-full border p-2 rounded">
                    <input type="hidden" id="availability" name="availability" value="1"
                        class="w-full border p-2 rounded">
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
                        onclick="closeVanModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#vansTable').DataTable();
        });
    </script>


    <script>
        function openVanModal() {
            const modal = document.getElementById('vanModal');
            const form = document.getElementById('vanForm');
            form.action = "{{ route('admin.vans.store') }}";
            document.getElementById('modalTitle').textContent = "Add Van";
            document.getElementById('method').value = '';
            modal.classList.remove('hidden');
        }

        function editVan(id) {
            fetch(`/admin/vans/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const modal = document.getElementById('vanModal');
                    const form = document.getElementById('vanForm');
                    form.action = `/admin/vans/${id}`;
                    document.getElementById('modalTitle').textContent = "Edit Van";
                    document.getElementById('method').value = 'PUT';
                    document.getElementById('model').value = data.model;
                    document.getElementById('plate_number').value = data.license_plate; // Ensure field names match
                    document.getElementById('capacity').value = data.capacity;
                    document.getElementById('rate').value = data.rental_rate; // Match rental rate field
                    modal.classList.remove('hidden');
                })
                .catch(error => console.error('Error fetching van details:', error));
        }

        function closeVanModal() {
            const modal = document.getElementById('vanModal');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
