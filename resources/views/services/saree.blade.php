<x-app-layout>
    <x-slot name="header">
        <h2 class="font-playfair text-2xl text-gray-800 leading-tight">
            {{ $service->name }}
        </h2>
    </x-slot>

    <div class="min-h-screen py-12 px-6" style="background: radial-gradient(circle at top left, #ffe3a3, #fbc0c6);">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10 font-playfair">
            {{ $service->name }}
        </h1>

        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg text-center relative">
            <!-- Image -->
            <img src="{{ asset('images/' . $service->image) }}" alt="{{ $service->name }}"
     class="mx-auto w-64 h-64 object-cover rounded-lg mb-6 shadow-md">



            <!-- Description -->
            <p class="text-gray-700 text-base mb-6 text-center leading-relaxed">
                {{ $service->description ?? 'Our saree draping service is designed to make you look graceful and elegant for any occasion.' }}
            </p>

            <!-- Price -->
            <div class="text-lg font-semibold text-gray-800 mb-4">
                RM{{ number_format($service->price, 2) }}
            </div>

            <!-- Quantity Selector -->
            <div class="mb-6">
                <label for="quantity" class="block text-gray-700 mb-2 font-medium">Pax</label>
                <div class="flex items-center justify-center gap-2">
                    <button type="button" onclick="updateQuantity(-1)"
                        class="w-10 h-10 text-lg font-bold bg-gray-100 rounded-full hover:bg-gray-200">-</button>
                    <input id="quantity" name="quantity" type="text" value="0"
                        class="w-16 text-center py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-400"
                        readonly>
                    <button type="button" onclick="updateQuantity(1)"
                        class="w-10 h-10 text-lg font-bold bg-gray-100 rounded-full hover:bg-gray-200">+</button>
                </div>
            </div>

            <!-- Add to Booking Form -->
            <form id="sareeForm">
                @csrf
                <input type="hidden" name="service" value="{{ $service->name }}">
                <input type="hidden" name="price" value="{{ $service->price }}">
                <input type="hidden" name="quantity" id="form-quantity" value="0">

                <button type="submit"
                    class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-8 rounded-full shadow">
                    Add to Booking
                </button>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script -->
    <script>
        function updateQuantity(change) {
            const quantityInput = document.getElementById('quantity');
            const formQuantityInput = document.getElementById('form-quantity');
            let currentValue = parseInt(quantityInput.value) || 0;

            let newValue = currentValue + change;
            if (newValue < 0) newValue = 0;
            if (newValue > 10) {
                newValue = 10;
                Swal.fire({
                    icon: 'info',
                    title: 'Limit Reached',
                    text: 'Maximum 10 pax for saree draping session.',
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            quantityInput.value = newValue;
            formQuantityInput.value = newValue;
        }

        document.getElementById('sareeForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const qty = parseInt(document.getElementById('form-quantity').value);

            if (qty === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Quantity Required',
                    text: 'Please select at least one pax before adding to booking.',
                    confirmButtonColor: '#f472b6'
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
                    title: 'Added Successfully!',
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
                    confirmButtonColor: '#f472b6'
                });
            });
        });
    </script>
</x-app-layout>
