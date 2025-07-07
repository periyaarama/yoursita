@props(['currentStep'])

@php
    $steps = ['Booking', 'Schedule', 'Review', 'Payment', 'Confirm'];
@endphp

<div class="relative w-full max-w-4xl mx-auto my-8">
    <!-- Full horizontal line -->
    <div class="absolute top-5 left-0 right-0 h-1 bg-gray-300 z-0"></div>

    <div class="flex justify-between relative z-10">
        @foreach ($steps as $index => $step)
            @php $stepNumber = $index + 1; @endphp
            <div class="flex flex-col items-center text-center w-1/5">
                <!-- Step circle -->
                <div class="w-10 h-10 rounded-full flex items-center justify-center
                    {{ $currentStep >= $stepNumber ? 'bg-pink-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                    {{ $stepNumber }}
                </div>
                <!-- Step label -->
                <span class="mt-2 text-sm font-medium
                    {{ $currentStep >= $stepNumber ? 'text-pink-600' : 'text-gray-500' }}">
                    {{ $step }}
                </span>
            </div>
        @endforeach
    </div>
</div>
