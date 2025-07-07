<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Group Henna Booking
        </h2>
    </x-slot>

    <div class="min-h-screen px-4 py-12" style="background: radial-gradient(circle at top left, #ffe3a3, #fbc0c6);">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg text-center relative">

            <!-- Back Button -->
            <a href="{{ route('services.henna') }}"
                class="absolute top-6 left-6 z-[40] bg-pink-100 text-pink-700 px-4 py-1.5 text-sm rounded-full font-semibold hover:bg-pink-200 transition">
                ← Back
            </a>

            <h1 class="text-3xl font-bold text-gray-800 mb-6">Group Henna Booking</h1>

            @php $service = $services->first(); @endphp

            @if ($service)
                <img src="{{ $service['img'] }}" alt="Group Henna"
                    class="w-full max-w-md mx-auto rounded-lg shadow mb-6">

                <p class="text-gray-700 mb-6">
                    Ideal for weddings and celebrations. Our artist offers theme-based designs for group sessions with 3 or more individuals.
                </p>

                <!-- Quantity Selector -->
                <div class="mb-6 text-center">
                    <label class="block text-gray-700 font-medium mb-2">Group Size</label>
                    <div class="flex justify-center items-center gap-2">
                        <button type="button" onclick="updateGroupQty(-1)"
                            class="w-10 h-10 text-lg font-bold bg-gray-100 rounded-full hover:bg-gray-200">-</button>

                        <input id="groupQty" type="text" value="3" readonly
                            class="w-16 text-center py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-400">

                        <button type="button" onclick="updateGroupQty(1)"
                            class="w-10 h-10 text-lg font-bold bg-gray-100 rounded-full hover:bg-gray-200">+</button>
                    </div>
                </div>

                <!-- Add to Booking Form -->
                <form id="groupHennaForm">
                    @csrf
                    <input type="hidden" name="service" value="{{ $service['name'] }}">
                    <input type="hidden" name="price" value="{{ $service['price'] }}">
                    <input type="hidden" name="quantity" id="form-groupQty" value="3">

                    <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-8 rounded-full shadow">
                        Add to Booking
                    </button>
                </form>
            @else
                <p class="text-red-600 font-bold">No group henna service found in the database.</p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function updateGroupQty(change) {
            const input = document.getElementById('groupQty');
            const hidden = document.getElementById('form-groupQty');
            let value = parseInt(input.value) || 0;

            let newValue = value + change;
            if (newValue < 1) newValue = 1;

            input.value = newValue;
            hidden.value = newValue;
        }

        document.getElementById('groupHennaForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const quantity = parseInt(document.getElementById('form-groupQty').value);
            if (quantity < 3) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Group size too small',
                    text: 'Please select at least 3 participants for group henna.',
                    confirmButtonColor: '#f472b6',
                });
                return;
            }

            const form = this;
            const data = new FormData(form);

            fetch("{{ route('booking.add') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: data
            })
            .then(response => {
                if (!response.ok) throw new Error("Network error");
                return response.text();
            })
            .then(() => {
                Swal.fire({
                    title: 'Group Henna Added!',
                    text: 'Do you want to book another service?',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, continue',
                    cancelButtonText: 'No, go to bookings',
                    confirmButtonColor: '#f472b6',
                    cancelButtonColor: '#6b7280'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('dashboard', ['#services']) }}";
                    } else {
                        window.location.href = "{{ route('booking.view') }}";
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: error.message,
                    confirmButtonColor: '#f472b6',
                });
            });
        });
    </script>
</x-app-layout>
