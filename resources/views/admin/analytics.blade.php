<x-app-layout :bodyClass="Auth::check() && Auth::user()->hasRole('admin') ? 'bg-[#FFD8A9]' : ''">
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">📈 Admin Analytics Dashboard</h2>
    </x-slot>

    

    <div class="p-6 min-h-screen">
        <div class="max-w-7xl mx-auto">
            {{-- Metric Cards --}}
           <form method="GET" action="{{ route('admin.analytics.report') }}" class="mb-4 flex items-center gap-3">
    <label for="year" class="font-semibold text-sm">📅 Download Report by Year:</label>
    <select name="year" id="year" class="border border-gray-300 px-2 py-1 rounded">
        <option value="">-- All Years --</option>
        @for($y = now()->year; $y >= 2020; $y--)
            <option value="{{ $y }}">{{ $y }}</option>
        @endfor
    </select>
    <button type="submit"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        🧾 Download
    </button>
</form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mb-6">
                <div class="p-4 bg-pink-100 rounded-lg shadow text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Total Clients</h3>
                    <p class="text-3xl text-pink-700 mt-2">{{ $clientCount }}</p>
                </div>

                <div class="p-4 bg-green-100 rounded-lg shadow text-center">
    <h3 class="text-lg font-semibold text-gray-700">Monthly Income ({{ now()->format('F') }})</h3>
    <p class="text-3xl text-green-700 mt-2">RM {{ number_format($currentMonthIncome ?? 0, 2) }}</p>
</div>

            </div>

            {{-- Charts Section --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
   
<!-- Booking Trends -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">📊 Booking Trends by Service (Monthly)</h3>
        <canvas id="bookingChart" height="200"></canvas>
    </div>

    <!-- Cancelled Bookings by Reason -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">📉 Cancelled Bookings by Reason</h3>
        <canvas id="cancelReasonsChart" height="200"></canvas>
    </div>

    <!-- Monthly Income Line Chart -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">📈 Monthly Income Over Time</h3>
        <canvas id="incomeLineChart" height="300"></canvas>
    </div>

    <!-- Popular Services (Donut) -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">🎯 Popular Services</h3>
        <canvas id="popularServicesChart" height="200"></canvas>
    </div>

     
 {{-- Customer Feedback Section --}}
<div class="bg-white p-6 rounded-lg shadow mt-10 col-span-2 w-full">

    <h3 class="text-lg font-semibold text-gray-700 mb-6">📝 Customer Feedback</h3>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="text-left text-gray-600 border-b">
                    <th class="pb-3">Feedback</th>  
                    <th class="pb-3">Name</th>
                    <th class="pb-3">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedback as $fb)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">{{ $fb->message }}</td>
                        <td class="py-4">{{ $fb->name }}</td>
                        <td class="py-4">{{ \Carbon\Carbon::parse($fb->created_at)->format('d M, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($feedback->isEmpty())
            <p class="text-gray-500 mt-6">No feedbacks found.</p>
        @endif
    </div>
</div>

</div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.onload = function () {
            // Booking Trends - Stacked Bar
            const bookingCtx = document.getElementById('bookingChart').getContext('2d');
            new Chart(bookingCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($months) !!},
                    datasets: {!! json_encode($bookingDatasets) !!}
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { stacked: true },
                        y: { stacked: true, beginAtZero: true }
                    },
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            //Monthly Income
const incomeCtx = document.getElementById('incomeLineChart').getContext('2d');
new Chart(incomeCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($months) !!},
        datasets: [{
            label: 'Income (RM)',
            data: {!! json_encode($incomeByMonth) !!},
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(99, 102, 241, 0.2)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'RM ' + value;
                    }
                }
            }
        }
    }
});

            // Cancelled Bookings - Bar Chart
          const cancelCtx = document.getElementById('cancelReasonsChart').getContext('2d');
new Chart(cancelCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($cancelReasons->pluck('cancel_reason')) !!},
        datasets: [{
            label: 'Cancellations',
            data: {!! json_encode($cancelReasons->pluck('total')) !!},
            backgroundColor: '#f87171',
            borderColor: '#dc2626',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        },
        plugins: {
            legend: { display: false }
        }
    }
});

            // Popular Services - Donut Chart
            const popularCtx = document.getElementById('popularServicesChart').getContext('2d');
            new Chart(popularCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($popularServices->pluck('service')) !!},
                    datasets: [{
                        data: {!! json_encode($popularServices->pluck('total')) !!},
                      backgroundColor: {!! json_encode(
    $popularServices->pluck('service')->map(function () {
        return '#' . substr(md5(uniqid()), 0, 6);
    })
) !!},
borderWidth: 1

                    }]
                },
                options: {
    responsive: true,
    plugins: {
        legend: { position: 'right' }
    },
    layout: {
        padding: {
            top: 0,
            bottom: 0
        }
    }
}

            });
        };
    </script>
</x-app-layout>
