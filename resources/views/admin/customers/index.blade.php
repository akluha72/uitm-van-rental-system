<x-app-layout>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-72 bg-gray-500 text-white p-4">
            <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
            <nav class="space-y-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-blue-600">Dashboard</a>
                <a href="{{ route('admin.vans.index') }}"
                    class="{{ request()->routeIs('admin.vans.index') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-gray-600">Manage
                    Vans</a>
                <a href="{{ route('admin.customers.index') }}"
                    class="{{ request()->routeIs('admin.customers.index') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-gray-600">Manage
                    Customers</a>
                <a href="{{ route('admin.payments.index') }}"
                    class="{{ request()->routeIs('admin.payments.index') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-gray-600">Manage
                    Payments</a>
                <a href="{{ route('admin.payments.export') }}"
                    class="{{ request()->routeIs('admin.payments.export') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-gray-600">Export
                    Payments</a>
            </nav>
        </div>
        <div class="container mx-auto p-6 relative">
            <h1 class="text-2xl font-bold mb-4">Manage Customers</h1>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Customers Table -->
            <div class="overflow-x-auto">
                <table id="customersTable" class="min-w-full bg-white border">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2 text-black">First Name</th>
                            <th class="border px-4 py-2 text-black">Last Name</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Phone</th>
                            <th class="border px-4 py-2">View License</th>
                            <th class="border px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $customer)
                            <tr>
                                <td class="border px-4 py-2">{{ $customer->first_name }}</td>
                                <td class="border px-4 py-2">{{ $customer->last_name }}</td>
                                <td class="border px-4 py-2">{{ $customer->email }}</td>
                                <td class="border px-4 py-2">{{ $customer->phone }}</td>
                
                        
                                <td class="border px-4 py-2">
                                    <a class="text-blue-500" href="{{ asset('storage/' . $customer->license_path) }}"
                                        target="_blank">View</a>
                                </td>
                                <td class="border px-4 py-2">
                                    <button class="bg-yellow-500 text-white px-2 py-1 rounded"
                                        onclick="editCustomer({{ $customer->id }})">Edit</button>

                                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST"
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
    </div>

    <!-- Add/Edit Modal -->
    <div id="customerModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-1/3 p-6 rounded shadow-lg">
            <h2 id="modalTitle" class="text-xl font-bold mb-4">Add Customer</h2>
            <form id="customerForm" method="POST">
                @csrf
                <input type="hidden" id="method" name="_method">
                <div class="mb-4">
                    <label for="name" class="block font-bold mb-2">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="name" class="block font-bold mb-2">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="email" class="block font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block font-bold mb-2">Phone</label>
                    <input type="text" id="phone" name="phone" class="w-full border p-2 rounded">
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
                        onclick="closeCustomerModal()">Cancel</button>
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
            $('#customersTable').DataTable();
        });

        function openCustomerModal() {
            const modal = document.getElementById('customerModal');
            const form = document.getElementById('customerForm');
            form.action = "{{ route('admin.customers.store') }}";
            document.getElementById('modalTitle').textContent = "Add Customer";
            document.getElementById('method').value = '';
            modal.classList.remove('hidden');
        }

        function editCustomer(id) {
            fetch(`/admin/customers/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    const modal = document.getElementById('customerModal');
                    const form = document.getElementById('customerForm');
                    form.action = `/admin/customers/${id}`;
                    document.getElementById('modalTitle').textContent = "Edit Customer";
                    document.getElementById('method').value = 'PUT';
                    document.getElementById('first_name').value = data.first_name;
                    document.getElementById('last_name').value = data.last_name;
                    document.getElementById('email').value = data.email;
                    document.getElementById('phone').value = data.phone;
                    modal.classList.remove('hidden');
                });
        }

        function closeCustomerModal() {
            const modal = document.getElementById('customerModal');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
