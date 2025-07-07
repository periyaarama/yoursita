<x-app-layout :bodyClass="Auth::check() && Auth::user()->hasRole('admin') ? 'bg-[#FFD8A9]' : ''">
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Admin Dashboard
        </h2>
    </x-slot>

    <!-- ✅ Flash Success Message -->
    @if(session('success'))
        <div id="successAlert" class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative max-w-4xl mx-auto mt-6" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>

        <script>
            setTimeout(() => {
                const alert = document.getElementById('successAlert');
                if (alert) alert.remove();
            }, 3000);
        </script>
    @endif

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/themes/light.css" />

    <!-- Calendar Container -->
    <div class="max-w-6xl mx-auto px-4 pb-12 mt-10">
        <div class="bg-white p-4 rounded-xl border border-gray-300 shadow-md relative">

            <!-- 🔖 Legend and Button -->
            <div class="flex justify-between items-start mb-4">
                <!-- Legend -->
                <div class="text-sm text-gray-700 flex flex-wrap gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded bg-green-200 border border-green-500"></span>
                        Completed
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded bg-red-200 border border-red-500"></span>
                        Cancelled
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded bg-pink-200 border border-pink-400"></span>
                        Upcoming
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded border-2 border-[#f59fb3]"></span>
                        Today
                    </div>
                </div>

                <!-- Add Booking Button -->
                <a href="{{ route('admin.bookings.create') }}"
                   class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                    + Add Booking
                </a>
            </div>


            <!-- Calendar -->
            <div id="calendar" class="mt-16"></div>
        </div>
    </div>

    <!-- Styles -->
    <style>
        #calendar {
            min-height: 600px;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background: transparent !important;
            border: 3px solid #f59fb3 !important;
            border-radius: 0.75rem;
        }
    </style>

    <!-- Calendar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                height: 'auto',
                dayMaxEventRows: true,
                events: {!! json_encode($bookings) !!},

                eventContent: function(arg) {
                    const props = arg.event.extendedProps || {};
                    const viewType = arg.view.type;

                    let bgColor = 'bg-pink-200';
                    if (props.status === 'completed') bgColor = 'bg-green-200';
                    else if (props.status === 'cancelled') bgColor = 'bg-red-200';

                    if (viewType === 'dayGridMonth') {
                        return {
                            html: `<div class="${bgColor} px-2 py-1 rounded text-sm font-semibold text-gray-800 truncate">
                                ${arg.event.title}
                            </div>`
                        };
                    }

                    if (viewType.startsWith('list')) {
                        return {
                            html: `
                                <div class="bg-yellow-100 rounded-lg shadow p-3 space-y-1 text-sm leading-tight text-gray-800">
                                    <div class="font-semibold">${arg.event.title}</div>
                                    <div><strong>Location:</strong> ${props.location}</div>
                                    <div><strong>Service:</strong> ${props.service}</div>
                                    <div><strong>Price:</strong> RM${props.price}</div>
                                    <div><strong>Notes:</strong> ${props.notes}</div>
                                </div>
                            `
                        };
                    }

                    return { html: `<div>${arg.event.title}</div>` };
                }
            });

            calendar.render();
        });
    </script>
</x-app-layout>
