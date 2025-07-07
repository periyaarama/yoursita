<x-app-layout>

<!-- Timeline Stepper -->
    <x-timeline :currentStep="5" />

       <div class="max-w-xl mx-auto mt-4">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded flex items-center justify-between">
        <span class="text-sm">For further discussion or special requests, feel free to contact Yosita directly.</span>
        <a href="{{ route('dashboard') }}#contact"
           class="ml-4 bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-1.5 rounded shadow">
            Contact Yosita
        </a>
    </div>
</div>

    <div class="p-6 bg-white rounded shadow-md mt-4 max-w-xl mx-auto">


        <h2 class="text-xl font-semibold text-green-700 mb-4">✅ Payment Successful</h2>

     


        <ul class="text-gray-800 space-y-2 text-sm">
            <li><strong>Amount Paid:</strong> RM{{ number_format($amount / 100, 2) }}</li>
            <li><strong>Transaction ID:</strong> {{ $transactionId }}</li>
            <li><strong>Date:</strong> {{ $date }}</li>
        </ul>

        <div class="flex justify-end mt-6 gap-3">
    <a href="{{ route('my_bookings') }}" class="bg-pink-500 text-white px-6 py-2 rounded-lg shadow hover:bg-pink-600 transition">
        Go to My Bookings
    </a>
    <a href="{{ route('dashboard') }}" class="bg-pink-500 text-white px-6 py-2 rounded-lg shadow hover:bg-pink-600 transition">
        Back to Home
    </a>
</div>

    </div>
</x-app-layout>
