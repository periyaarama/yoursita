<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Personal Makeover</h2>
    </x-slot>

    <div class="min-h-screen px-4 py-12 bg-gradient-to-br from-[#ffe3a3] to-[#fbc0c6]">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10 font-playfair">Personal Makeover</h1>

        <div class="max-w-5xl mx-auto space-y-10">

            <!-- ROM Package A & B in SAME white box -->
            <div class="bg-white p-8 rounded-xl shadow-lg space-y-8">
                @foreach (['ROM Package A', 'ROM Package B'] as $package)
                    @php $service = $services[$package]; @endphp
                   <form action="{{ route('booking.add') }}" method="POST"
      class="packageForm flex flex-col md:flex-row justify-between items-start gap-6">

                        @csrf
                        <div class="flex items-start gap-6">
                            <img src="{{ asset('images/' . ($service->image ?? 'placeholder.jpg')) }}" alt="{{ $service->type }}" class="w-52 h-52 object-cover rounded-xl shadow-md">
                            <div>
                                <h3 class="text-2xl font-semibold text-gray-800">{{ $service->type }}</h3>
                                <p class="text-pink-600 font-bold mb-2">RM{{ number_format($service->price, 2) }}</p>
                                <ul class="list-disc pl-5 text-gray-700 text-sm">
                                    <li>Makeup</li>
                                    <li>Hairstyling</li>
                                    <li>Saree / Lengha Pleating and Draping</li>
                                    <li>1 set accessories (if required)</li>
                                    <li>Flowers (if required)</li>
                                    @if ($package === 'ROM Package B')
                                        <li>Henna Wrist Length</li>
                                    @endif
                                </ul>
                                <input type="hidden" name="service" value="{{ $service->type }}">
                                <input type="hidden" name="price" value="{{ $service->price }}">
                                <input type="hidden" name="quantity" value="1">
                            </div>
                        </div>
                        <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-full shadow self-center">
                            Add to Booking
                        </button>
                    </form>
                @endforeach
            </div>

            <!-- Engagement Package -->
            @php $engagement = $services['Engagement Package']; @endphp
          <form action="{{ route('booking.add') }}" method="POST"
      class="packageForm bg-white p-8 rounded-xl shadow-lg flex flex-col md:flex-row justify-between gap-6 items-start">


                @csrf
                <div class="flex items-start gap-6">
                    <img src="{{ asset('images/' . ($engagement->image ?? 'engagement.jpg')) }}" alt="Engagement" class="w-52 h-52 object-cover rounded-xl shadow-md">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800">Engagement Package</h3>
                        <p class="text-pink-600 font-bold mb-2">RM{{ number_format($engagement->price, 2) }}</p>
                        <ul class="list-disc pl-5 text-gray-700 text-sm">
                            <li>Professional Make Up HD/Natural</li>
                            <li>Professional Hair Styling</li>
                            <li>Saree Prepleating x 2</li>
                            <li>Saree Draping x 2</li>
                            <li>Premium accessories x 2</li>
                            <li>Hair Flowers</li>
                            <li>Premium Lashes</li>
                            <li>Hair extensions</li>
                            <li>Touch up for 2nd Look</li>
                            <li>Waiting charges (to change 2nd look)</li>
                        </ul>
                        <input type="hidden" name="service" value="{{ $engagement->type }}">
                        <input type="hidden" name="price" value="{{ $engagement->price }}">
                        <input type="hidden" name="quantity" value="1">
                    </div>
                </div>
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-full shadow self-center">
                    Add to Booking
                </button>
            </form>

            <!-- Other Occasions -->
            @php $other = $services['Other Occasions']; @endphp
            <form id="makeoverForm"
      action="{{ route('booking.add') }}"
      method="POST"
      class="bg-white p-6 rounded-xl shadow-md flex flex-col md:flex-row items-center justify-between gap-6">

                @csrf
                <img src="{{ asset('images/' . ($other->image ?? 'other_occasion.jpg')) }}" alt="Other Occasion" class="w-52 h-52 object-cover rounded-xl shadow-md">
                <div class="flex-1">
                    <h3 class="text-2xl font-semibold text-gray-800">Other Occasions</h3>
                    <p class="text-pink-600 font-bold mb-2">RM{{ number_format($other->price, 2) }}</p>

                    <p class="text-gray-700 mb-4">Full makeover including makeup, hairdo and saree draping.</p>

                    <div class="mb-4">
                        <label for="otherOccasion" class="block text-sm font-medium text-gray-700 mb-1">Enter Occasion</label>
                        <input type="text" id="otherOccasion" name="occasion" class="w-full px-4 py-2 border rounded-lg border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="updateQty(-1)" class="w-10 h-10 text-lg font-bold bg-gray-100 rounded-full hover:bg-gray-200">-</button>
                           <input id="qty" name="quantity" type="number" value="0" min="0" max="4" readonly
       class="w-16 text-center py-2 border border-gray-300 rounded">

                            <button type="button" onclick="updateQty(1)" class="w-10 h-10 text-lg font-bold bg-gray-100 rounded-full hover:bg-gray-200">+</button>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="service" value="Personal Makeover – Other Occasion">
                <input type="hidden" name="price" value="{{ $other->price }}">

                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-full shadow self-start md:self-auto">
                    Add to Booking
                </button>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function updateQty(change) {
        const qtyInput = document.getElementById('qty');
        let currentQty = parseInt(qtyInput.value) || 0;

        currentQty += change;

        if (currentQty < 0) currentQty = 0;
        if (currentQty > 4) {
            currentQty = 4;
            // Top-right toast alert
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: 'Limit Reached',
                text: 'Maximum 4 pax per makeup session.',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        }

        qtyInput.value = currentQty;
    }

    document.getElementById('makeoverForm').addEventListener('submit', function (e) {
        const qty = parseInt(document.getElementById('qty').value);

        if (qty < 1) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Quantity Required',
                text: 'Please select at least 1 pax to proceed.',
                confirmButtonColor: '#f472b6'
            });
        }
    });
</script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: '{{ session('success') }}',
    text: 'Do you want to book another service?',
    showCancelButton: true,
    confirmButtonText: 'Yes, continue',
    cancelButtonText: 'No, go to bookings',
    confirmButtonColor: '#f472b6',
    cancelButtonColor: '#6b7280',
}).then((result) => {
    if (result.isConfirmed) {
        // ✅ Redirect back to services section (update route if needed)
        window.location.href = "{{ route('dashboard') }}#services";
    } else {
        // Go to booking view page
        window.location.href = "{{ route('booking.view') }}";
    }
});
</script>
@endif


</x-app-layout>
