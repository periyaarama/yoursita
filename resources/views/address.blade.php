<x-app-layout>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />


    <x-slot name="header">
        <h2 class="font-playfair text-2xl text-gray-800 leading-tight">
            Confirm Booking Details
        </h2>
    </x-slot>


  <div class="px-6 py-12 min-h-screen bg-gray-100">
    <!-- Timeline Stepper -->
    <x-timeline :currentStep="2" />

    <div class="max-w-5xl mx-auto px-4 mt-10 py-10 bg-white shadow-md rounded-xl">


    @if(session('rewardRedeem'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 mb-6 rounded-xl shadow">
            🎁 <strong>You're redeeming your Full Personal Makeover!</strong> Please proceed with your booking details.
        </div>
    @endif

    <form id="bookingForm" action="{{ route('booking.confirm') }}" method="POST">


    @csrf

    <!-- Back Button -->
    <a href="{{ route('booking.view') }}"
        class="inline-block mb-4 bg-pink-100 text-pink-700 px-4 py-1.5 text-sm rounded-full font-semibold hover:bg-pink-200 transition">
        ← Back to Bookings
    </a>

   <!-- Address & Contact Details -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <!-- Name (Full Width) -->
    <div class="col-span-2">
        <label class="block text-gray-700 font-semibold mb-2">Name:</label>
        <input type="text" name="name"
            value="{{ old('name', session('booking_name', Auth::user()->firstName . ' ' . Auth::user()->lastName)) }}"
            class="w-full border border-gray-300 p-3 rounded-md" required />
    </div>

    <!-- Full Address -->
    <div class="col-span-2">
        <label class="block text-gray-700 font-semibold mb-2">Address (Area and Street):</label>
        <textarea name="address" rows="3" class="w-full border border-gray-300 p-3 rounded-md" required>{{ old('address', session('booking_address')) }}</textarea>
    </div>

    <!-- Phone Number (Left) -->
    <div>
        <label class="block text-gray-700 font-semibold mb-2">Phone Number:</label>
        <input type="tel" name="phoneNumber"
            value="{{ old('phoneNumber', session('booking_phoneNumber', Auth::user()->phoneNumber)) }}"
            class="w-full border border-gray-300 p-3 rounded-md" required />
    </div>

    <!-- Postcode (Right) -->
    <div>
        <label class="block text-gray-700 font-semibold mb-2">Postcode:</label>
        <input type="text" name="postcode"
            value="{{ old('postcode', session('booking_postcode')) }}"
            class="w-full border border-gray-300 p-3 rounded-md" required />
    </div>

    <!-- City/District/Town -->
    <div>
        <label class="block text-gray-700 font-semibold mb-2">City/District/Town:</label>
        <input type="text" name="city"
            value="{{ old('city', session('booking_city')) }}"
            class="w-full border border-gray-300 p-3 rounded-md" required />
    </div>

    <!-- State -->
    <div>
        <label class="block text-gray-700 font-semibold mb-2">State:</label>
        <select name="state" id="state" class="w-full border border-gray-300 p-3 rounded-md" required>
    <option value="">-- Select State --</option>
    <option value="Selangor">Selangor</option>
    <option value="Johor">Johor</option>
    <option value="Kuala Lumpur">Kuala Lumpur</option>
    <option value="Penang">Penang</option>
    <option value="Perak">Perak</option>
    <option value="Negeri Sembilan">Negeri Sembilan</option>
    <option value="Melaka">Melaka</option>
    <option value="Pahang">Pahang</option>
    <option value="Kelantan">Kelantan</option>
    <option value="Terengganu">Terengganu</option>
    <option value="Kedah">Kedah</option>
    <option value="Perlis">Perlis</option>
    <option value="Sabah">Sabah</option>
    <option value="Sarawak">Sarawak</option>
</select>

    </div>

    <!-- Date & Time Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Date Picker -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Select a Date:</label>
            <input type="text" id="calendar" name="selectedDate"
                value="{{ old('selectedDate', session('booking_date')) }}"
                class="w-full border border-gray-300 p-3 rounded-md text-gray-800 font-medium"
                placeholder="Pick a date" required>
        </div>

        <!-- Time Picker -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Time to get ready:</label>
            <input type="time" id="timepicker" name="selectedTime"
                value="{{ old('selectedTime', session('booking_time')) }}"
                class="w-full border border-gray-300 p-3 rounded-md text-gray-800 font-medium cursor-pointer"
                min="06:00" max="22:00" required>
        </div>
    </div>

    <!-- Notes -->
    <div class="col-span-2 mb-6">
        <label class="block text-gray-700 font-semibold mb-2">Additional Notes (Optional):</label>
        <textarea name="notes" rows="3"
            class="w-full border border-gray-300 p-3 rounded-md">{{ old('notes', session('booking_notes')) }}</textarea>
    </div>

</div>


    <!-- Submit -->
    <div class="md:col-span-2 flex justify-end">
    <button class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-lg shadow">
        Confirm Booking
    </button>
</div>




</form>


    </div>
    </div> <!-- end max-w-5xl -->
</div> <!-- end gray background wrapper -->

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    // Date Picker
    fetch('/api/blocked-slots')
    .then(res => res.json())
    .then(data => {
        flatpickr("#calendar", {
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            minDate: "today",
            disable: data,  // ✅ Disable blocked dates directly
            disableMobile: true,
        });
    });


    // Booking Form Validation
    document.getElementById('bookingForm').addEventListener('submit', function (e) {
        const name = document.querySelector('[name="name"]').value.trim();
        const phone = document.querySelector('[name="phoneNumber"]').value.trim();
        const postcode = document.querySelector('[name="postcode"]').value.trim();
        const date = document.getElementById('calendar').value.trim();
        const time = document.getElementById('timepicker').value.trim();

        const phoneRegex = /^01\d{8,9}$/;
        const postcodeRegex = /^\d{5}$/;

        if (!name || !phone || !postcode || !date || !time) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Missing Information',
                text: 'Please complete all required fields before submitting.',
                confirmButtonColor: '#ec4899',
            });
            return;
        }

        if (!phoneRegex.test(phone)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Invalid Phone Number',
                text: 'Phone number must start with 01 and contain 10–11 digits.',
                confirmButtonColor: '#ec4899',
            });
            return;
        }

        if (!postcodeRegex.test(postcode)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Invalid Postcode',
                text: 'Postcode must be exactly 5 digits.',
                confirmButtonColor: '#ec4899',
            });
            return;
        }
    });

    
</script>

    <!-- Custom Styles -->
    <style>
        /* Calendar Styling */
        .flatpickr-calendar {
            border: 1px solid #f9a8d4 !important;
        }

        .flatpickr-day.today {
            border-color: #ec4899;
            background: #ffe4f0;
        }

        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #ec4899;
            color: white;
            border-color: #ec4899;
        }

        .flatpickr-weekday {
            color: #ec4899;
            font-weight: 600;
        }

        .flatpickr-day:hover {
            background: #f9a8d4;
            color: white;
        }

        /* Keep only icon pink */
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(43%) sepia(78%) saturate(420%) hue-rotate(288deg) brightness(98%) contrast(90%);
        }
    </style>
</x-app-layout>
