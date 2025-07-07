<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Bookings History</h2>
    </x-slot>

    <div class="bg-gradient-to-r from-[#FFE1AB] to-[#FBC0C6] py-12 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-6" x-data="{ tab: 'upcoming' }">

        <!-- Tabs -->
        <div class="flex gap-4 mb-6">
            <button
                :class="tab === 'upcoming' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                class="px-4 py-2 rounded font-semibold"
                @click="tab = 'upcoming'">
                Upcoming
            </button>
            <button
                :class="tab === 'completed' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                class="px-4 py-2 rounded font-semibold"
                @click="tab = 'completed'">
                Completed
            </button>
        </div>

       <!-- Upcoming Bookings -->
<div x-show="tab === 'upcoming'" class="bg-white shadow rounded-lg p-4">
    @if ($upcomingBookings->isEmpty())
        <p class="text-gray-500 text-center">You have no upcoming bookings.</p>
    @else
        <table class="w-full text-sm table-auto border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border">No</th>
                    <th class="p-3 border">Name</th>
                    <th class="p-3 border">Date</th>
                    <th class="p-3 border">Time</th>
                    <th class="p-3 border">Address</th>
                    <th class="p-3 border">Payment History</th>
                    <th class="p-3 border">Details</th>
                    <th class="p-3 border">Cancel</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($upcomingBookings as $groupKey => $group)
                    @php
                        $first = $group->first();
                        $totalFull = $group->sum('full_payment');
                        $totalDeposit = $group->sum('deposit');
                        $paymentLeft = $totalFull - $totalDeposit;
                        [$date, $time, $address] = explode('|', $groupKey);
                    @endphp

                    <!-- Booking Row -->
                    <tr class="border-t">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3">{{ $first->name }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($time)->format('h:i A') }}</td>
                        <td class="p-3">{{ $address }}, {{ $first->city }}, {{ $first->state }} {{ $first->postcode }}</td>
                        <td class="p-3">
                            <button onclick="togglePayment('payment-{{ $loop->iteration }}')" class="text-gray-700 hover:underline text-sm">
                                View Payment
                            </button>
                        </td>
                        <td class="p-3">
                            <button onclick="toggleDetails('upcoming-{{ $loop->iteration }}')" class="text-gray-700 hover:underline text-sm">
                                View Services
                            </button>
                        </td>
                        <td class="p-3">
                            <form method="POST" action="{{ route('booking.cancel.group') }}" class="cancel-form">
                                @csrf
                                <input type="hidden" name="booking_ids[]" value="{{ implode(',', $group->pluck('id')->toArray()) }}">
                                <input type="hidden" name="cancel_reason" class="cancel-reason-input">
                                <button type="submit" title="Cancel Booking"
                                    class="text-white bg-red-600 hover:bg-red-700 rounded-full w-6 h-6 flex items-center justify-center shadow">
                                    <span class="text-sm font-bold">×</span>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Services Row -->
                    <tr id="details-upcoming-{{ $loop->iteration }}" class="hidden bg-gray-50">
                        <td colspan="8" class="p-4">
                            <ul class="list-disc ml-6">
                                @foreach ($group as $item)
                                    <li>{{ $item->service }} × {{ $item->quantity }} — RM {{ number_format($item->price * $item->quantity, 2) }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>

                    <!-- Payment Details Row -->
                    <tr id="payment-payment-{{ $loop->iteration }}" class="hidden bg-gray-100">
                        <td colspan="8" class="p-4 text-sm">
                            <strong>Payment Breakdown:</strong>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Deposit Paid: RM {{ number_format($totalDeposit, 2) }}</li>
                                <li>Full Payment Due: RM {{ number_format($totalFull, 2) }}</li>
                                <li>Payment Left: RM {{ number_format($paymentLeft, 2) }}</li>
                                <li>Transaction ID: <span class="text-gray-500">{{ $first->transaction_id ?? '—' }}</span></li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

        <!-- Completed Bookings -->
        <div x-show="tab === 'completed'" class="bg-white shadow rounded-lg p-4">
            @if ($completedBookings->isEmpty())
                <p class="text-gray-500 text-center">You have no past bookings yet.</p>
            @else
                <table class="w-full text-sm table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 border">No</th>
                            <th class="p-3 border">Name</th>
                            <th class="p-3 border">Date</th>
                            <th class="p-3 border">Time</th>
                            <th class="p-3 border">Address</th>
                            <th class="p-3 border">Txn ID</th>
                            <th class="p-3 border">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @foreach ($completedBookings->groupBy('transaction_id') as $txnId => $bookings)
                            @php $first = $bookings->first(); @endphp
                            <tr class="border-t">
                                <td class="p-3">{{ $count++ }}</td>
                                <td class="p-3">{{ $first->name }}</td>
                                <td class="p-3">{{ \Carbon\Carbon::parse($first->selectedDate)->format('M d, Y') }}</td>
                                <td class="p-3">{{ $first->selectedTime }}</td>
                                <td class="p-3">{{ $first->address }}, {{ $first->city }}, {{ $first->state }} {{ $first->postcode }}</td>
                                <td class="p-3 text-xs text-gray-500">{{ $first->transaction_id }}</td>
                                <td class="p-3">
                                    <button onclick="toggleDetails('{{ $txnId }}')" class="text-blue-500 hover:underline">
                                        View Services
                                    </button>
                                </td>
                            </tr>
                            <tr id="details-{{ $txnId }}" class="hidden bg-gray-50">
                                <td colspan="7" class="p-4">
                                    <strong>Services:</strong>
                                    <ul class="list-disc ml-6 mt-2">
                                        @foreach ($bookings as $booking)
                                            <li>{{ $booking->service }} × {{ $booking->quantity }} — RM{{ number_format($booking->price * $booking->quantity, 2) }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleDetails(id) {
            const row = document.getElementById('details-' + id);
            if (row) row.classList.toggle('hidden');
        }

        function confirmCancel(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Cancel Booking?',
                text: 'Your deposit will not be refunded. Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, cancel it',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });

            return false;
        }


    function togglePayment(id) {
        const row = document.getElementById('payment-' + id);
        if (row) row.classList.toggle('hidden');
    }


        document.querySelectorAll('.cancel-form').forEach(form => {
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        Swal.fire({
            title: 'Cancel Booking?',
            text: 'Your deposit will not be refunded.',
            icon: 'warning',
            input: 'select',
            inputOptions: {
                'Change of plan': 'Change of plan',
                'Found another service': 'Found another service',
                'Date/time not suitable': 'Date/time not suitable',
                'Other': 'Other (type below)'
            },
            inputPlaceholder: 'Select a reason',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            inputValidator: (value) => {
                if (!value) return 'Please select a reason!';
            },
            preConfirm: (reason) => {
                if (reason === 'Other') {
                    return Swal.fire({
                        title: 'Write your reason',
                        input: 'text',
                        inputPlaceholder: 'Your reason...',
                        inputValidator: (value) => {
                            if (!value) return 'Reason cannot be empty';
                        }
                    }).then(result => result.value);
                } else {
                    return reason;
                }
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                form.querySelector('.cancel-reason-input').value = result.value;
                form.submit();
            }
        });
    });
});
    </script>
</x-app-layout>
