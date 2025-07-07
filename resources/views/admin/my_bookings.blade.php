<x-app-layout :bodyClass="Auth::check() && Auth::user()->hasRole('admin') ? 'bg-[#FFD8A9]' : ''">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Bookings</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6" x-data="{ tab: 'upcoming' }">
            <!-- Tabs -->
            <div class="flex space-x-4 mb-6">
                @foreach (['upcoming', 'completed', 'cancelled'] as $tabName)
                    <button
                        @click="tab = '{{ $tabName }}'"
                        :class="tab === '{{ $tabName }}' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800'"
                        class="px-4 py-2 rounded capitalize">
                        {{ ucfirst($tabName) }}
                    </button>
                @endforeach
            </div>

            <!-- Booking Tables -->
            @foreach (['upcoming' => $upcomingBookings, 'completed' => $completedBookings, 'cancelled' => $cancelledBookings] as $status => $bookings)
                <div x-show="tab === '{{ $status }}'" class="bg-white rounded shadow p-4">
                    @if ($bookings->isEmpty())
                        <p class="text-gray-500 text-center capitalize">No {{ $status }} bookings found.</p>
                    @else
                        <table class="w-full table-auto text-sm border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3 border">No</th>
                                    <th class="p-3 border">Name</th>
                                    <th class="p-3 border">Service</th>
                                    <th class="p-3 border">Date</th>
                                    <th class="p-3 border">Time</th>
                                    <th class="p-3 border">Address</th>
                                    <th class="p-3 border">Phone</th>
                                    <th class="p-3 border">Txn ID</th>
                                    <th class="p-3 border">Payment Left</th>
                                    <th class="p-3 border">Status</th>
                                    @if ($status === 'cancelled')
                                        <th class="p-3 border">Reason</th>
                                    @endif
                                    @if ($status === 'upcoming')
                                        <th class="p-3 border">Complete</th>
                                        <th class="p-3 border">Cancel</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $index => $booking)
                                    <tr class="border-t">
                                        <td class="p-3">{{ $index + 1 }}</td>
                                        <td class="p-3">{{ $booking->name }}</td>
                                        <td class="p-3">{{ $booking->service }}</td>
                                        <td class="p-3">{{ \Carbon\Carbon::parse($booking->selectedDate)->format('M d, Y') }}</td>
                                        <td class="p-3">{{ \Carbon\Carbon::parse($booking->selectedTime)->format('h:i A') }}</td>
                                        <td class="p-3">{{ $booking->address }}, {{ $booking->city }}, {{ $booking->state }} {{ $booking->postcode }}</td>
                                        <td class="p-3">{{ $booking->phoneNumber }}</td>
                                        <td class="p-3 text-xs text-gray-500">{{ $booking->transaction_id ?? '—' }}</td>

                                        @php
                                            $deposit = 250;
                                            $total = $booking->full_payment ?? 0;
                                            $left = max($total - $deposit, 0);
                                        @endphp

                                        <td class="text-red-600 font-semibold">RM {{ number_format($left, 2) }}</td>

                                        <td class="p-3 text-{{ $status === 'cancelled' ? 'red' : ($status === 'completed' ? 'green' : 'blue') }}-600 font-semibold">
                                            {{ ucfirst($booking->status) }}
                                        </td>

                                        @if ($status === 'cancelled')
                                            <td class="p-3 text-sm text-gray-700 italic">
                                                {{ $booking->cancel_reason ?? '—' }}
                                            </td>
                                        @endif

                                        @if ($status === 'upcoming')
                                            <td class="p-3">
                                                <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" onsubmit="return confirm('Mark this booking as completed?')">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:underline text-sm">✔</button>
                                                </form>
                                            </td>
                                            <td class="p-3">
                                                <form action="{{ route('booking.cancel.group') }}" method="POST" onsubmit="return confirm('Cancel this booking?')">
                                                    @csrf
                                                    <input type="hidden" name="booking_ids[]" value="{{ $booking->id }}">
                                                    <input type="hidden" name="cancel_reason" value="Cancelled by admin">
                                                    <button type="submit" class="text-red-600 hover:underline text-sm">✘</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
</x-app-layout>
