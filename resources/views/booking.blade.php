<x-app-layout>
    <x-slot name="header">
        <h2 class="font-playfair text-2xl text-gray-800 leading-tight">
            Your Bookings
        </h2>
    </x-slot>



<div class="px-6 py-12 min-h-screen bg-gray-100">


     <!-- Timeline Stepper -->
    <x-timeline :currentStep="1" />
    <!-- Page width and padding -->
    <div class="max-w-7xl mx-auto px-4">


        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

       @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        {{ session('error') }}
    </div>
@endif



        <!-- Catalog Book Trigger Button -->
        <div class="mb-4">
            <button onclick="openCatalog()"
                class="inline-block bg-yellow-300 hover:bg-yellow-400 text-gray-800 font-semibold py-2 px-4 rounded shadow">
                📘 Catalog Book
            </button>
        </div>

        @if(count($bookings) > 0)
            <table class="min-w-full table-auto bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-pink-200 text-gray-800 text-sm text-center">
                        <th class="px-4 py-2">Service</th>
                        <th class="px-4 py-2">Price (RM)</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-2 py-2 w-64">Reference Photo</th>
                        <th class="px-4 py-2 w-28">Preview</th>
                        <th class="px-4 py-2">Catalog Pick?</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr class="text-center">
                            <td class="border px-4 py-2">{{ $booking->service }}</td>
                            <td class="border px-4 py-2">{{ number_format($booking->price, 2) }}</td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('booking.updateQuantity', $booking->id) }}" method="POST"
                                    class="inline-flex items-center justify-center gap-1">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="action" value="decrease"
                                        class="px-2 bg-gray-200 hover:bg-gray-300 rounded">&minus;</button>
                                    <span class="px-2 font-semibold">{{ $booking->quantity }}</span>
                                    <button type="submit" name="action" value="increase"
                                        class="px-2 bg-gray-200 hover:bg-gray-300 rounded">+</button>
                                </form>
                            </td>
                            <td class="border px-2 py-2 text-xs">
                                <form method="POST" action="{{ route('photo.upload') }}" enctype="multipart/form-data"
                                    class="space-y-2">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input type="file" name="photos[]" multiple class="text-xs border rounded p-1 w-full">

                                    <button type="submit"
                                        class="block mx-auto bg-pink-500 text-white text-sm px-4 py-1.5 rounded shadow hover:bg-pink-600 transition">
                                        Upload
                                    </button>
                                </form>


                            </td>
                         <td class="border px-4 py-2">
    @php
        $photos = \App\Models\BookingPhoto::where('booking_id', $booking->id)->get();
    @endphp

    @if($photos->isEmpty())
        <span class="text-gray-400 text-xs">No photos</span>
    @else
        <ul class="space-y-1 text-sm text-gray-800">
            @foreach($photos as $photo)
                <li class="flex items-center justify-between">
                    <span class="truncate max-w-[120px]">{{ $photo->file_name }}</span>

                    <form action="{{ route('photo.delete', $photo->id) }}" method="POST"
                          onsubmit="return confirm('Remove this photo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-500 text-xs font-bold hover:text-red-700 ml-2 px-1">
                            &times;
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</td>


                            <td class="border px-4 py-2">
                                <form action="{{ route('booking.comment', $booking->id) }}" method="POST">
                                    @csrf
                                    <textarea name="comment" rows="1" class="w-full text-xs border rounded p-1"
                                        placeholder="e.g. Hairdo B + Portfolio"
                                        onblur="this.form.submit()">{{ $booking->comment }}</textarea>
                                </form>
                            <td class="border px-2 py-2 w-12 text-center">
                                <button onclick="confirmRemove({{ $booking->id }})"
                                    class="bg-red-500 hover:bg-red-600 rounded-full p-2 inline-flex items-center justify-center"
                                    title="Remove Booking">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </td>





                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="text-center font-semibold bg-gray-100">
                        <td colspan="2" class="px-4 py-3 text-right">Grand Total (RM):</td>
                        <td colspan="5" class="text-left px-4 py-3 text-pink-600">
                            {{ number_format($bookings->sum(fn($b) => $b->price * $b->quantity), 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="flex justify-between items-center px-6 mt-6">
                <button onclick="confirmClear()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Clear All Bookings
                </button>

                <a href="{{ route('next.page') }}" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                    Next →
                </a>
            </div>

        @else
            <p class="text-gray-700 text-center">You have no bookings yet.</p>
        @endif
    </div>
        </div> <!-- end of max-w-7xl wrapper -->
</div> <!-- end of full background wrapper -->






    <!-- Catalog Modal -->
    <div id="catalogModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white w-[90%] max-w-4xl rounded-lg shadow-lg p-8 relative">
            <!-- Close Button -->
            <button onclick="closeCatalog()"
                class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-xl font-bold">
                &times;
            </button>

            <!-- Category Selection -->
            <div id="categorySelection" class="text-center">
                <h2 class="text-2xl font-bold mb-4">📘 Catalog Book</h2>
                <div class="flex justify-center space-x-4">
                    <button onclick="showFlipbook('hairdo')"
                        class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Hairdo</button>
                    <button onclick="showFlipbook('henna')"
                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Henna</button>
                </div>
            </div>

            <!-- Flipbook Container -->
            <div id="flipbookContainer" class="hidden mt-6 text-center">
                <!-- Back Button -->
                <button onclick="goBackToCatalog()" id="backBtn"
                    class="mb-4 bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-1 rounded">
                    ← Back
                </button>


                <!-- Flipbook Controls -->
                <div class="flex justify-center items-center mb-4 space-x-4">
                    <button onclick="$('#flipbook').turn('previous')"
                        class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded shadow">← Previous</button>
                    <button onclick="$('#flipbook').turn('next')"
                        class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded shadow">Next →</button>
                </div>

                <!-- Flipbook Display -->
                <div id="flipbook" class="mx-auto border shadow-lg rounded overflow-hidden"></div>
            </div>



            <!-- SweetAlert2 -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <!-- Turn.js -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/3/turn.min.js"></script>


            <script>
                function confirmRemove(id) {
                    Swal.fire({
                        title: 'Remove this booking?',
                        text: "This action cannot be undone.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#9ca3af',
                        confirmButtonText: 'Yes, remove it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/booking/remove/${id}`;

                            const token = document.createElement('input');
                            token.type = 'hidden';
                            token.name = '_token';
                            token.value = '{{ csrf_token() }}';

                            const method = document.createElement('input');
                            method.type = 'hidden';
                            method.name = '_method';
                            method.value = 'DELETE';

                            form.appendChild(token);
                            form.appendChild(method);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }

                function confirmClear() {
                    Swal.fire({
                        title: 'Clear all bookings?',
                        text: "This will delete all your bookings permanently.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#9ca3af',
                        confirmButtonText: 'Yes, clear all'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('booking.clear') }}';

                            const token = document.createElement('input');
                            token.type = 'hidden';
                            token.name = '_token';
                            token.value = '{{ csrf_token() }}';

                            const method = document.createElement('input');
                            method.type = 'hidden';
                            method.name = '_method';
                            method.value = 'DELETE';

                            form.appendChild(token);
                            form.appendChild(method);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
            </script>

            <script>
                function openCatalog() {
                    document.getElementById('catalogModal').classList.remove('hidden');
                    document.getElementById('categorySelection').classList.remove('hidden');
                    document.getElementById('flipbookContainer').classList.add('hidden');
                    $('#flipbook').html('');
                }

                function closeCatalog() {
                    document.getElementById('catalogModal').classList.add('hidden');
                    $('#flipbook').turn('destroy').html('');
                }

                function showFlipbook(category) {
                    document.getElementById('categorySelection').classList.add('hidden');
                    document.getElementById('flipbookContainer').classList.remove('hidden');

                    const pageCounts = {
                        hairdo: 5,
                        henna: 5
                    };

                    const flipbook = $('#flipbook');
                    flipbook.html('');

                    for (let i = 1; i <= pageCounts[category]; i++) {
                        const page = $('<div />').addClass('page').html(`<img src="/images/catalog/${category}/${i}.jpg" class="w-full h-full object-cover" alt="${category} ${i}">`);
                        flipbook.append(page);
                    }

                    flipbook.turn({
                        width: 800,
                        height: 600,
                        autoCenter: true
                    });
                }
            </script>

            <script>
                function goBackToCatalog() {
                    const flipbook = $('#flipbook');

                    // only destroy if initialized
                    if (flipbook.data('turn')) {
                        flipbook.turn('destroy');
                    }

                    flipbook.html('');
                    document.getElementById('flipbookContainer').classList.add('hidden');
                    document.getElementById('categorySelection').classList.remove('hidden');
                }
            </script>

</x-app-layout>