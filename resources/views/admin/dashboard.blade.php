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

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Dashboard Overview -->
            <div class="p-6">
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

            <!-- Booking Table -->
            <div class=" flex-1 p-4 overflow-y-auto ">
                <div class="container mx-auto">
                    <h2 class="text-xl font-bold mb-4">Pending Review Bookings</h2>
                    <!-- Responsive Table Wrapper -->
                    <div class="overflow-x-auto">
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
                                        <td class="border px-4 py-2 text-black">{{ ucfirst($booking->booking_status) }}
                                        </td>
                                        <td class="border px-4 py-2 text-black">{{ $booking->start_date }} ->
                                            {{ $booking->end_date }}</td>
                                        <td class="border px-4 py-2 text-black">
                                            <button class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded"
                                                onclick="openModal('{{ $booking->id }}', '{{ $booking->booking_reference }}', '{{ $booking->user->first_name }}', '{{ $booking->van->model }}', '{{ $booking->start_date }}', '{{ $booking->end_date }}', '{{ ucfirst($booking->booking_status) }}', '{{ $booking->user->license_path }}')">
                                                Review
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal (Hidden by Default) -->
    <div id="reviewModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-1/2 p-6 rounded shadow-lg relative">
            <button class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded"
                onclick="closeModalBookingReview()">X</button>
            <h2 class="text-xl font-bold mb-4">Review Booking</h2>
            <div id="bookingDetails" class="text-gray-700 mb-4">
                <!-- Booking details will be dynamically injected here -->
            </div>
            <div id="licensePreview" class="mb-4">
                <h3 class="font-bold text-gray-700 mb-2">User License</h3>
                <iframe id="licensePDF" src="" class="w-full h-80 border rounded" frameborder="0"></iframe>
            </div>
            <div class="mb-4">
                <h3 class="font-bold text-gray-700 mb-2">Action</h3>
                <div>
                    <label class="mr-4">
                        <input type="radio" name="action" value="approved" class="action-radio"
                            onchange="handleActionChange()"> Approve
                    </label>
                    <label>
                        <input type="radio" name="action" value="rejected" class="action-radio"
                            onchange="handleActionChange()"> Reject
                    </label>
                </div>
            </div>
            <div id="rejectionComment" class="mb-4">
                <h3 class="font-bold text-gray-700 mb-2">Rejection Comment </h3>
                <textarea id="commentField" class="w-full h-24 border p-2 rounded" placeholder="Enter rejection reason" required></textarea>
            </div>
            <div class="flex justify-end mt-6">
                <button class="bg-blue-500 text-white px-4 py-2 rounded" id="submitButton"
                    onclick="submitBookingReview()">Submit</button>
            </div>
        </div>
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
                });
            });
        });
    </script>

    <script>
        function openModal(id, reference, customer, van, startDate, endDate, status, licensePath) {
            const modal = document.getElementById('reviewModal');
            const details = document.getElementById('bookingDetails');
            const licensePDF = document.getElementById('licensePDF');
            const rejectionComment = document.getElementById('rejectionComment');
            const commentField = document.getElementById('commentField');

            // Populate modal content
            details.innerHTML = `
            <p><strong>Booking Reference:</strong> ${reference}</p>
            <p><strong>Customer:</strong> ${customer}</p>
            <p><strong>Van:</strong> ${van}</p>
            <p><strong>Booking Period:</strong> ${startDate} to ${endDate}</p>
            <p><strong>Status:</strong> ${status}</p>
        `;
            modal.dataset.bookingId = id;
            // Load license PDF
            licensePDF.src = `/storage/${licensePath}`;

            // Reset modal state
            modal.classList.remove('hidden');
            rejectionComment.classList.add('hidden');
            commentField.value = '';
            document.querySelectorAll('.action-radio').forEach(radio => (radio.checked = false));
        }

        function closeModalBookingReview() {
            const modal = document.getElementById('reviewModal');
            modal.classList.add('hidden');
        }

        function handleActionChange() {
            const rejectionComment = document.getElementById('rejectionComment');
            const selectedAction = document.querySelector('input[name="action"]:checked').value;
            if (selectedAction === 'rejected') {
                rejectionComment.classList.remove('hidden');
            } else {
                rejectionComment.classList.add('hidden');
            }
        }

        function submitBookingReview() {
            const id = document.querySelector('#reviewModal').dataset.bookingId; // Ensure ID is passed into the modal
            const selectedAction = document.querySelector('input[name="action"]:checked');
            const commentField = document.getElementById('commentField');
            const comment = commentField.value.trim();

            if (!selectedAction) {
                alert('Please select an action.');
                return;
            }

            const actionValue = selectedAction.value;
            if (actionValue === 'rejected' && !comment) {
                alert('Please provide a rejection reason.');
                return;
            }

            fetch(`/admin/bookings/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        status: actionValue,
                        comment: comment,
                        bookingId: id
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Booking status updated successfully!');
                        closeModalBookingReview();
                        location.reload();
                    } else {
                        alert('Failed to update booking status.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</x-app-layout>
