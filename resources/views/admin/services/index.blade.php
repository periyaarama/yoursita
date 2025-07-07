<x-app-layout :bodyClass="Auth::check() && Auth::user()->hasRole('admin') ? 'bg-[#FFD8A9]' : ''">
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Manage Services</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 pb-12 mt-10">
        <div class="bg-white p-6 rounded-xl border border-gray-300 shadow-md">

            <!-- Top bar: Service List + Filter -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Service List</h2>

                <!-- Filter Dropdown (Right-aligned) -->
                <form method="GET" action="{{ route('admin.services.index') }}" class="flex items-center space-x-2">
                    <label for="name" class="font-semibold">Filter by:</label>
                    <select name="name" id="name" onchange="this.form.submit()" class="border border-gray-300 rounded px-3 py-1">
                        <option value="">All</option>
                        @foreach ($serviceNames as $name)
                            <option value="{{ $name }}" {{ request('name') === $name ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Service Table -->
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-800">
                        <th class="px-4 py-2 text-left">Service</th>
                        <th class="px-4 py-2 text-left">Type</th>
                        <th class="px-4 py-2 text-left">Sub Service</th>
                        <th class="px-4 py-2 text-left">Price (RM)</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        <tr class="border-b hover:bg-pink-50">
                            <td class="px-4 py-2">{{ $service->name }}</td>
                            <td class="px-4 py-2">{{ $service->type ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $service->sub_service ?? '-' }}</td>
                            <td class="px-4 py-2">RM {{ number_format($service->price, 2) }}</td>
                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="{{ route('admin.services.edit', $service->id) }}"
                                   class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                            
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
