<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Individual Henna Booking</h2>
    </x-slot>

    <div class="min-h-screen px-4 py-12" style="background: radial-gradient(circle at top left, #ffe3a3, #fbc0c6);">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg relative">
            <<a href="{{ route('services.henna') }}"

                class="absolute top-6 left-6 z-[60] bg-pink-100 text-pink-700 px-4 py-1.5 text-sm rounded-full font-semibold hover:bg-pink-200 transition">
                ← Back
            </a>

            <h1 class="text-3xl font-bold text-center text-gray-800 mb-6 font-playfair">Individual Henna Booking</h1>

            <p class="text-center text-gray-700 mb-8 text-lg font-medium leading-relaxed">
                Choose from elegant designs for hand or leg — tailored for your style and comfort.
            </p>

            <form id="individualHennaForm">
                @csrf

                <!-- Hand Designs -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-pink-600 mb-4">🖐 Hand Designs</h3>
                    <div class="space-y-4">
                        @foreach ($handDesigns as $item)
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset($item['img']) }}" alt="{{ $item['name'] }}"
                                        class="w-24 h-24 rounded-lg object-cover shadow" />
                                    <span class="text-base font-medium text-gray-700">
                                        {{ $item['name'] }} – RM{{ $item['price'] }}
                                    </span>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" onclick="setQty('{{ $item['key'] }}', 1)"
                                        class="pax-btn" id="{{ $item['key'] }}Btn1">1 pax</button>
                                    <button type="button" onclick="setQty('{{ $item['key'] }}', 2)"
                                        class="pax-btn" id="{{ $item['key'] }}Btn2">2 pax</button>
                                </div>
                                <input type="hidden" name="selections[{{ $item['name'] }}]" id="{{ $item['key'] }}Qty" value="0">
                                <input type="hidden" name="prices[{{ $item['name'] }}]" value="{{ $item['price'] }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Leg Designs -->
                <div class="mb-10">
                    <h3 class="text-xl font-bold text-pink-600 mb-4">🦵 Leg Designs</h3>
                    <div class="space-y-4">
                        @foreach ($legDesigns as $item)
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset($item['img']) }}" alt="{{ $item['name'] }}"
                                        class="w-24 h-24 rounded-lg object-cover shadow" />
                                    <span class="text-base font-medium text-gray-700">
                                        {{ $item['name'] }} – RM{{ $item['price'] }}
                                    </span>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" onclick="setQty('{{ $item['key'] }}', 1)"
                                        class="pax-btn" id="{{ $item['key'] }}Btn1">1 pax</button>
                                    <button type="button" onclick="setQty('{{ $item['key'] }}', 2)"
                                        class="pax-btn" id="{{ $item['key'] }}Btn2">2 pax</button>
                                </div>
                                <input type="hidden" name="selections[{{ $item['name'] }}]" id="{{ $item['key'] }}Qty" value="0">
                                <input type="hidden" name="prices[{{ $item['name'] }}]" value="{{ $item['price'] }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <input type="hidden" name="service" value="Individual Henna">

                <div class="text-center mt-10">
                    <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-8 rounded-full shadow">
                        Add to Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .pax-btn {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            background-color: #f3f4f6;
            font-weight: 600;
            color: #1f2937;
            transition: all 0.2s;
        }

        .pax-btn.active,
        .pax-btn:hover {
            background-color: #ec4899;
            color: white;
        }
    </style>

    <script>
        function setQty(id, value) {
            document.getElementById(id + 'Qty').value = value;
            document.getElementById(id + 'Btn1').classList.remove('active');
            document.getElementById(id + 'Btn2').classList.remove('active');
            document.getElementById(id + 'Btn' + value).classList.add('active');
        }

        document.getElementById('individualHennaForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const inputs = form.querySelectorAll("input[type='hidden'][name^='selections']");
            let totalQty = 0;

            inputs.forEach(input => {
                totalQty += parseInt(input.value || 0);
            });

            if (totalQty === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nothing selected',
                    text: 'Please select at least one henna design.',
                    confirmButtonColor: '#f472b6',
                });
                return;
            }

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
                    title: 'Henna Added!',
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
