<x-app-layout>
    <div class="flex justify-evenly h-screen">
        <!-- Sidebar -->
        <div class="w-72 bg-gray-500 h-screen text-white p-4">
            <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
            <nav class="space-y-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-blue-600">Dashboard</a>
                <a href="{{ route('admin.vans.index') }}"
                    class="{{ request()->routeIs('admin.vans.index') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-gray-600">Manage
                    Vans</a>
                <a href="{{ route('admin.bookings.index') }}"
                    class="{{ request()->routeIs('admin.bookings.index') ? 'bg-gray-700' : '' }} block px-4 py-2 rounded hover:bg-gray-600">Manage
                    Bookings</a>
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
        {{-- dashboard overview --}}
        <div class="w-full p-6 flex flex-col">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded shadow">
                        Active Bookings
                        <p>{{ $data['activeBookings'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded shadow">
                        Available Vans:
                        <p>{{ $data['availableVans'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded shadow">
                        Monthly Revenue:
                        <p>${{ $data['monthlyRevenue'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded shadow">
                        Pending Bookings:
                        <p>{{ $data['pendingBookings'] }}</p>
                    </div>
                </div>
            </div>
            <div class="w-full p-6">
                <div class="container mx-auto">
                    <h2 class="text-xl font-bold mb-4">Booking List</h2>
                    <table id="bookingTable" class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Booking ID</th>
                                <th class="border px-4 py-2">Customer Name</th>
                                <th class="border px-4 py-2">Van</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Booking Date</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td class="border px-4 py-2 text-black">{{ $booking->booking_reference }}</td>
                                    <td class="border px-4 py-2 text-black">{{ $booking->user->first_name }}</td>
                                    <td class="border px-4 py-2 text-black">{{ $booking->van->model }}</td>
                                    <td class="border px-4 py-2 text-black">{{ ucfirst($booking->booking_status) }}</td>
                                    <td class="border px-4 py-2 text-black">{{ $booking->start_date }} -> {{ $booking->end_date }}</td>
                                    <td class="border px-4 py-2 text-black">
                                        @if ($booking->booking_status === 'pending confirmation')
                                            <button class="bg-green-500 text-white px-2 py-1 rounded" onclick="changeStatus('{{ $booking->id }}', 'approved')">Approve</button>
                                            <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="changeStatus('{{ $booking->id }}', 'rejected')">Reject</button>
                                        @elseif ($booking->booking_status === 'approved')
                                            <button class="bg-blue-500 text-white px-2 py-1 rounded" onclick="changeStatus('{{ $booking->id }}', 'completed')">Mark as Completed</button>
                                        @elseif ($booking->booking_status === 'rejected')
                                            <span class="text-gray-500">No Actions Available</span>
                                        @elseif ($booking->booking_status === 'completed')
                                            <span class="text-gray-500">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->

    </div>

    <!-- DataTables CDN Scripts -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
        $('#bookingTable').DataTable({
            pageLength: 10,
            // dom: 'l' // Sets the default number of rows per page to 20
        });
    });
        });
    </script>
</x-app-layout>
