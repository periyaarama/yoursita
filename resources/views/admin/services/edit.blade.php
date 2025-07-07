<x-app-layout :bodyClass="Auth::check() && Auth::user()->hasRole('admin') ? 'bg-[#FFD8A9]' : ''">
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Service</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8 bg-white p-6 rounded shadow border border-gray-300">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Service Name -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Service Name</label>
                <input type="text" name="name" value="{{ old('name', $service->name) }}" class="w-full border border-gray-300 p-2 rounded" required>
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Price (RM)</label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $service->price) }}" class="w-full border border-gray-300 p-2 rounded" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700 transition">Update Service</button>
        </form>
    </div>
</x-app-layout>
