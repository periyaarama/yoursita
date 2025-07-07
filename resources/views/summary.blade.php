<x-app-layout>
    <x-slot name="header">
        <h2 class="font-playfair text-2xl text-gray-800 leading-tight">
            Booking Summary
        </h2>
    </x-slot>

    <!-- Timeline Stepper -->
    <x-timeline :currentStep="3" />

    <!-- Top Back Button -->
    <div class="max-w-6xl mx-auto mt-4 px-4">
        <a href="{{ route('schedule') }}"
            class="inline-block bg-pink-100 text-pink-700 px-4 py-1.5 text-sm rounded-full font-semibold hover:bg-pink-200 transition">
            ← Back to Schedule
        </a>
    </div>

    @php
        $first = $bookings->first();
        $isReward = $first->is_reward ?? false;
        $transportation = $isReward ? 0 : session('transportation_fee', 0);
        $total = $bookings->sum(fn($b) => $b->price * $b->quantity);
        $deposit = 250.00;
        $totalPayable = ($isReward ? 0 : $total + $transportation) + $deposit;
    @endphp

    <div class="max-w-6xl mx-auto mt-6 px-4 pb-12">
        @if($isReward)
            <div class="bg-green-100 border-l-4 border-green-500 text-green-900 p-4 mb-6 rounded-xl shadow">
                🎉 <strong>This is a Reward Redemption Booking!</strong> You’re receiving a 
                <span class="font-bold">FREE Full Personal Makeover</span>.
                Only the deposit applies — transportation is covered for you!
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left: Services -->
            <div class="flex-1 space-y-4">
                @foreach ($bookings as $booking)
                    <div class="flex items-start gap-4 border-b pb-4">
                        @if($booking->photos && $booking->photos->count())
                            <img src="{{ asset('storage/' . $booking->photos->first()->photo_path) }}"
                                 class="w-24 h-24 object-cover rounded-lg shadow border" />
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center text-sm text-gray-500">
                                No Photo
                            </div>
                        @endif

                        <div class="flex-1 space-y-1">
                            <p class="text-lg font-semibold text-gray-800">{{ $booking->service }}</p>
                            <p class="text-sm text-black-700">Quantity: {{ $booking->quantity }}</p>
                            <p class="text-sm text-black-700">Price: RM {{ number_format($booking->price, 2) }}</p>
                            <p class="text-sm text-black-700">Total: RM {{ number_format($booking->price * $booking->quantity, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right Column: Address + Order Summary -->
            <div class="w-full lg:w-1/3 space-y-4">
                @if($first)
                    <div class="border border-gray-200 rounded-lg p-4 space-y-2 bg-white shadow">
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Address</span>
                            <span class="text-gray-900 font-semibold text-right">
                                {{ session('booking_address') }},
                                {{ session('booking_postcode') }},
                                {{ session('booking_city') }},
                                {{ session('booking_state') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Date</span>
                            <span class="text-gray-900 font-semibold text-right">
                                {{ \Carbon\Carbon::parse(session('booking_date'))->format('F j, Y') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Time</span>
                            <span class="text-gray-900 font-semibold text-right">
                                {{ \Carbon\Carbon::parse(session('booking_time'))->format('h:i A') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Notes</span>
                            <span class="text-gray-900 font-normal text-right">
                                {{ session('booking_notes') ?? '—' }}
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Order Summary -->
                <div class="bg-gray-50 border rounded-xl p-5 space-y-4 shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800">Order Summary</h3>

                    <div class="flex justify-between text-sm text-gray-700">
                        <span>Order Total</span>
                        <span>RM {{ number_format($isReward ? 0 : $total, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-sm text-gray-700">
                        <span>Transportation Fee</span>
                        <span>RM {{ number_format($transportation, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-sm text-gray-700">
                        <span>Deposit Fee</span>
                        <span>RM {{ number_format($deposit, 2) }}</span>
                    </div>

                    <hr class="my-2">

                    <div class="flex justify-between text-base font-semibold text-gray-800">
                        <span>Total Amount</span>
                        <span>RM {{ number_format($totalPayable, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-base font-semibold text-pink-600">
                        <span>Paying Now</span>
                        <span>RM {{ number_format($deposit, 2) }}</span>
                    </div>

                    <form id="depositForm" action="{{ route('stripe.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <input type="hidden" name="amount" id="paymentAmount" value="{{ $deposit }}">

                        <button type="button" id="depositBtn"
                            class="w-full mt-3 bg-pink-600 hover:bg-pink-700 text-white py-2 rounded-lg shadow text-sm font-medium">
                            Continue Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('depositBtn').addEventListener('click', function () {
            Swal.fire({
                title: 'Confirm Deposit Payment',
                html: `
                    <p class="text-sm">You are about to pay a <strong>non-refundable deposit of RM250</strong>.</p>
                    <p class="text-sm mt-2">This deposit secures your booking. If you cancel, the deposit will not be returned.</p>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Proceed',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#ec4899',
                cancelButtonColor: '#d1d5db',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('depositForm').submit();
                }
            });
        });
    </script>
</x-app-layout>
