<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Customer Dashboard</h1>

        <!-- Dashboard Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Active Bookings Card -->
            <div class="bg-white shadow rounded p-4">
                <h3 class="text-lg font-semibold">Active Bookings</h3>
                <p>{{ $activeBookingsCount }}</p>
            </div>

            <!-- Payment Due Card -->
            <div class="bg-white shadow rounded p-4">
                <h3 class="text-lg font-semibold">Total Payment Due</h3>
                <p>RM {{ number_format($duePayments, 2) }}</p>
            </div>

            <!-- Closest Payment Due -->
            <div class="bg-white shadow rounded p-4">
                <h3 class="text-lg font-semibold">Upcoming Payment Due</h3>
                @if ($closestPaymentDue)
                    <p>{{ $closestPaymentDue->start_date }} -
                        RM {{ number_format($closestPaymentDue->amount_due, 2) }}</p>
                @else
                    <p>No pending payments</p>
                @endif
            </div>
        </div>

        <!-- Current Bookings -->
        <div class="mt-6">
            <h3 class="text-xl font-bold mb-4">Current Bookings</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Booking Reference</th>
                        <th class="p-2 border">Van Model</th>
                        <th class="p-2 border">Pickup</th>
                        <th class="p-2 border">Drop-off</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Amount Paid</th>
                        <th class="p-2 border">Amount Due</th>
                        <th class="p-2 border">Total Amount</th>
                        <th class="p-2 border">Booking Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($currentBookings as $booking)
                        <tr>
                            <td class="p-2 border">{{ $booking->booking_reference }}</td>
                            <td class="p-2 border">{{ $booking->van->model ?? 'N/A' }}</td>
                            <td class="p-2 border">{{ $booking->start_date ?? 'N/A' }}</td>
                            <td class="p-2 border">{{ $booking->end_date ?? 'N/A' }}</td>
                            <td class="p-2 border">
                                <span class="{{ $statusClasses[$booking->booking_status] ?? '' }} font-semibold">
                                    {{ ucfirst($booking->booking_status ?? 'Unknown') }}
                                </span>
                            </td>
                            <td class="p-2 border">RM {{ number_format($booking->amount_paid, 2) }}</td>
                            <td class="p-2 border">RM {{ number_format($booking->amount_due, 2) }}</td>
                            <td class="p-2 border">RM {{ number_format($booking->total_amount, 2) }}</td>
                            <td class="p-2 border">{{ $booking->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-2 border text-center" colspan="8">No current bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $currentBookings->links() }}
            </div>
        </div>

        <!-- Booking History -->
        <div class="mt-12">
            <h3 class="text-xl font-bold mb-4">Booking History</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Booking Reference</th>
                        <th class="p-2 border">Van Model</th>
                        <th class="p-2 border">Pickup</th>
                        <th class="p-2 border">Drop-off</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Amount Paid</th>
                        <th class="p-2 border">Amount Due</th>
                        <th class="p-2 border">Booking Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookingHistory as $booking)
                        <tr>
                            <td class="p-2 border">{{ $booking->booking_reference }}</td>
                            <td class="p-2 border">{{ $booking->van->model ?? 'N/A' }}</td>
                            <td class="p-2 border">{{ $booking->start_date }}</td>
                            <td class="p-2 border">{{ $booking->end_date }}</td>
                            <td class="p-2 border">{{ ucfirst($booking->booking_status) }}</td>
                            <td class="p-2 border">RM {{ number_format($booking->amount_paid, 2) }}</td>
                            <td class="p-2 border">RM {{ number_format($booking->amount_due, 2) }}</td>
                            <td class="p-2 border">{{ $booking->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-2 border text-center" colspan="8">No booking history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $bookingHistory->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
