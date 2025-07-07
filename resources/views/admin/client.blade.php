<x-app-layout :bodyClass="Auth::check() && Auth::user()->hasRole('admin') ? 'bg-[#FFD8A9]' : ''">
    <div class="min-h-screen py-12 px-6">
        <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8">

            <h1 class="text-3xl font-bold mb-6">Clients</h1>

            <!-- Search -->
            <form method="GET" class="mb-6">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email"
                       class="border border-gray-300 p-2 rounded w-1/3 shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <button class="bg-yellow-500 text-white px-4 py-2 rounded ml-2 hover:bg-yellow-600">Search</button>
            </form>

            <!-- Clients Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full border text-left bg-white shadow-md rounded-xl">
                    <thead>
                        <tr class="bg-[#FBC0C6] text-white">
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Phone</th>
                            <th class="py-3 px-4">Loyalty Points</th>
                            <th class="py-3 px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr class="border-t hover:bg-yellow-50">
                                <td class="py-3 px-4">{{ $client->username }}</td>
                                <td class="py-3 px-4">{{ $client->email }}</td>
                                <td class="py-3 px-4">{{ $client->phoneNumber }}</td>
                                <td class="py-3 px-4">{{ $client->loyaltyPoints }}</td>
                                <td class="py-3 px-4">
                                    <form method="POST" action="{{ route('admin.clients.updatePoints', $client->id) }}" class="flex items-center gap-2">
                                        @csrf
                                        <input type="number" name="pointsToAdd" placeholder="+ Points"
       min="1" class="w-24 p-1 border rounded">
                                        <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Add</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-6">No clients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $clients->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
