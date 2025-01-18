<x-app-layout>


    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-72 bg-gray-500 text-white p-4">
            <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
            <nav class="space-y-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('admin.vans.index') }}"
                    class="{{ request()->routeIs('admin.vans.index') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-gray-600">Manage
                    Vans</a>
                <a href="{{ route('admin.customers.index') }}"
                    class="{{ request()->routeIs('admin.customers.index') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-gray-600">Manage
                    Customers</a>
                <a href="{{ route('admin.payments.index') }}"
                    class="{{ request()->routeIs('admin.payments.index') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-gray-600">Manage
                    Payments</a>
            </nav>
        </div>
        <div class="container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-4">Manage Payments</h1>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Export Payments Button -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.payments.export') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Export Payments</a>
            </div>

            <!-- Payments Table -->
            <div class="overflow-x-auto">
                <table id="paymentsTable" class="min-w-full bg-white border">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Payment ID</th>
                            <th class="border px-4 py-2">Booking ID</th>
                            <th class="border px-4 py-2">Customer Name</th>
                            <th class="border px-4 py-2">Amount Paid</th>
                            <th class="border px-4 py-2">Total Amount</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td class="border px-4 py-2">{{ $payment->id }}</td>
                                <td class="border px-4 py-2">{{ $payment->booking->booking_reference }}</td>
                                <td class="border px-4 py-2">{{ $payment->user->first_name }}</td>
                                <td class="border px-4 py-2">RM {{ $payment->amount_paid }}</td>
                                <td class="border px-4 py-2">RM {{ $payment->booking->total_amount }}</td>
                                <td class="border px-4 py-2">{{ ucfirst($payment->payment_status) }}</td>
                                <td class="border px-4 py-2">{{ $payment->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Edit Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-1/3 p-6 rounded shadow-lg">
            <h2 id="modalTitle" class="text-xl font-bold mb-4">Edit Payment</h2>
            <form id="paymentForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="status" class="block font-bold mb-2">Status</label>
                    <select id="status" name="status" class="w-full border p-2 rounded">
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                        <option value="refunded">Refunded</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
                        onclick="closePaymentModal()">Cancel</button>
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
            $('#paymentsTable').DataTable();
        });

        function editPayment(id) {
            fetch(`/admin/payments/${id}`)
                .then(response => response.json())
                .then(data => {
                    const modal = document.getElementById('paymentModal');
                    const form = document.getElementById('paymentForm');
                    form.action = `/admin/payments/${id}/update`;
                    document.getElementById('status').value = data.status;
                    modal.classList.remove('hidden');
                });
        }

        function closePaymentModal() {
            const modal = document.getElementById('paymentModal');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
