<x-app-layout :bodyClass="Auth::check() && Auth::user()->hasRole('admin') ? 'bg-[#FFD8A9]' : ''">
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Add New Booking</h2>
    </x-slot>

    <!-- Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-md mt-10 space-y-6">
        <form method="POST" action="{{ url('/admin/bookings') }}">
            @csrf

            <input type="hidden" name="status" value="upcoming">
            <input type="hidden" name="price" id="finalPrice">

            <!-- Walk-in Info -->
            <div>
                <label class="font-medium">Customer Name</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="font-medium">Email</label>
                    <input type="email" name="customer_email" class="w-full border rounded px-3 py-2" />
                </div>
                <div class="w-1/2">
                    <label class="font-medium">Phone</label>
                    <input type="text" name="customer_phone" class="w-full border rounded px-3 py-2" />
                </div>
            </div>

            <!-- Service -->
            <div>
                <label class="font-medium">Select Service</label>
                <select name="service" class="w-full border rounded px-3 py-2" id="serviceSelect">
                    @foreach ($services as $service)
                        <option value="{{ $service->name }}" data-price="{{ $service->price }}">
                            {{ $service->name }}
                            @if($service->type) — {{ $service->type }} @endif
                            @if($service->sub_service) ({{ $service->sub_service }}) @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Price Display -->
            <div id="priceContainer" class="text-pink-700 mt-2 hidden text-sm leading-relaxed space-y-1">
                <div><strong>Service Price:</strong> <span id="servicePrice">RM 0.00</span></div>
                <div><strong>Travel Fee:</strong> <span id="travelFee">RM 0.00</span></div>
                <div><strong>Total Price:</strong> <span id="totalPrice" class="text-lg font-bold">RM 0.00</span> <em>(Excluding RM250 deposit)</em></div>
            </div>

            <!-- Pax -->
            <div>
                <label class="font-medium">Quantity (Number of people)</label>
                <input type="number" name="quantity" class="w-full border rounded px-3 py-2" min="1" value="1" />
            </div>

            <!-- Date & Time -->
            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="font-medium">Date</label>
                    <input type="text" id="date" name="date" autocomplete="off" class="w-full border rounded px-3 py-2" />
                </div>
                <div class="w-1/2">
                    <label class="font-medium">Time</label>
                    <input type="time" name="time" class="w-full border rounded px-3 py-2" />
                </div>
            </div>

            <!-- Location -->
            <div>
                <label class="font-medium">Location</label>
                <input type="text" name="location" class="w-full border rounded px-3 py-2" required />
            </div>

            <!-- Notes -->
            <div>
                <label class="font-medium">Notes</label>
                <textarea name="notes" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <!-- Submit -->
            <button class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 mt-4">Submit Booking</button>
        </form>
    </div>

    <!-- Styles -->
    <style>
        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.flatpickr-disabled:hover {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            border-radius: 50% !important;
            cursor: not-allowed;
            opacity: 0.7;
        }
    </style>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.select2').select2({
                placeholder: "Select or search for a customer",
                allowClear: true
            });

            // Disable browser autofill and load Flatpickr
            document.querySelector('#date').setAttribute('autocomplete', 'off');

         fetch('/api/blocked-slots')
    .then(res => res.json())
    .then(data => {
        flatpickr("#date", {
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            minDate: "today",
            disable: data,
            disableMobile: true,
        });
    });



            const updatePriceDisplay = () => {
                const location = document.querySelector('input[name="location"]').value.toLowerCase();
                const quantity = parseInt(document.querySelector('input[name="quantity"]').value) || 1;
                const selected = document.querySelector('#serviceSelect').selectedOptions[0];
                const basePrice = parseFloat(selected?.getAttribute('data-price')) || 0;

                let travelFee = 0;
                if (location.includes('pahang')) travelFee = 80;
                else if (location.includes('selangor')) travelFee = 50;
                else if (location.includes('johor')) travelFee = 80;
                else if (location.includes('kuala lumpur')) travelFee = 65;
                else if (location.includes('perak')) travelFee = 80;
                else if (location.includes('penang')) travelFee = 90;
                else if (location.includes('negeri sembilan')) travelFee = 70;
                else if (location.includes('melaka')) travelFee = 75;
                else if (location.includes('kelantan')) travelFee = 85;
                else if (location.includes('terengganu')) travelFee = 85;
                else if (location.includes('kedah')) travelFee = 150;
                else if (location.includes('perlis')) travelFee = 180;
                else if (location.includes('sabah')) travelFee = 200;
                else if (location.includes('sarawak')) travelFee = 200;

                const serviceTotal = basePrice * quantity;
                const total = serviceTotal + travelFee;

                document.getElementById('servicePrice').textContent = `RM ${serviceTotal.toFixed(2)}`;
                document.getElementById('travelFee').textContent = `RM ${travelFee.toFixed(2)}`;
                document.getElementById('totalPrice').textContent = `RM ${total.toFixed(2)}`;
                document.getElementById('priceContainer').classList.remove('hidden');
                document.getElementById('finalPrice').value = total.toFixed(2);
            };

            document.querySelector('#serviceSelect').addEventListener('change', updatePriceDisplay);
            document.querySelector('input[name="location"]').addEventListener('input', updatePriceDisplay);
            document.querySelector('input[name="quantity"]').addEventListener('input', updatePriceDisplay);

            updatePriceDisplay();
        });
    </script>
</x-app-layout>
