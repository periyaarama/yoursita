<x-app-layout>
    <x-slot name="header">
        <h2 class="font-playfair text-2xl text-gray-800 leading-tight">
            Bridal Package
        </h2>
    </x-slot>

    <div class="min-h-screen py-12 px-6" style="background: radial-gradient(circle at top left, #ffe3a3, #fbc0c6);">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10 font-playfair">
            Bridal Package
        </h1>

        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg text-center relative">
    <!-- Image Carousel -->
    <div class="relative w-full overflow-hidden rounded-lg mb-6 bg-white">
        <div id="carousel" class="flex transition-transform duration-700 ease-in-out w-full">
    @foreach ($service->images as $img)
        <img src="{{ asset('images/' . $img) }}" class="w-full h-[420px] object-contain flex-shrink-0 bg-white" />
    @endforeach
</div>

    </div>

    <!-- Description -->
    <p class="text-gray-700 text-base mb-6 text-justify leading-relaxed">
        Our all-inclusive bridal package ensures you look stunning and radiant for your special day. Designed with complete care and perfection, this package covers:
    </p>

    <ul class="text-left text-gray-800 list-disc list-inside mb-6 text-sm leading-relaxed">
        <li>Bridal makeup with high quality fake eyelashes</li>
        <li>Hairstyling with hair extensions / accessories (if required)</li>
        <li>Fresh flowers – kondai maalai, etc.</li>
        <li>Saree / Lengha draping (Pleating & Ironing) ×2</li>
        <li>Bridal accessories ×2 sets (2nd saree change + 2nd sets of bridal accessories)</li>
        <li>Natural / instant henna for bride (any length as required)</li>
    </ul>

    <div class="text-lg font-semibold text-gray-800 mb-6">
    RM{{ number_format($service->price, 2) }}
</div>


    <!-- Add to Booking Form (No quantity) -->
    <form id="bridalForm">
        @csrf
        <input type="hidden" name="service" value="Bridal Package">
        <input type="hidden" name="price" value="1999.00">
        <input type="hidden" name="quantity" value="1">

        <button type="submit"
            class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-8 rounded-full shadow">
            Add to Booking
        </button>
    </form>
</div>

    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    <script>
        // Carousel Auto Scroll
        const carousel = document.getElementById('carousel');
        let index = 0;
        const slideCount = carousel.children.length;
        setInterval(() => {
            index = (index + 1) % slideCount;
            carousel.style.transform = `translateX(-${index * 100}%)`;
        }, 3000);


        document.getElementById('bridalForm').addEventListener('submit', function (e) {
    e.preventDefault();

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
            title: 'Bridal Package Added!',
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
