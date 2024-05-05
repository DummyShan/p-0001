<x-app-layout>
    <!-- <x-slot name="header">
        {{ __('COGON STATION:') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            {{ __('You are logged in!') }}
        </div>
    </div> -->
    <audio id="alertAudio">
        <source src="{{ asset('assets/alarm.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <audio id="alertFire">
        <source src="{{ asset('assets/fire-alarm.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    @if (session()->has('success'))
        <script>
            alertFire.play();
        </script>
        <div class="alert alert-success">
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">{{ session()->get('success') }}</span>
                </div>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-error">
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">{{ session()->get('error') }}</span>
                </div>
            </div>
        </div>
    @endif
    @can('user_access')
        <div class="flex">
            <div class="pr-10">
                <select
                    class="w-36 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Semester">
                    <option value="1">1st Sem</option>
                    <option value="2">2nd Sem</option>
                </select>
            </div>

            <div>
                <select
                    class="w-36 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="School Year">
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                </select>
            </div>
        </div>
        <div class="flex" style="padding-top: 10px; height: 100%;">
            <div class="w-2/5">
                <div class="w-full bg-gray-800 rounded-lg p-4">
                    <p class="text-white text-xl mb-4">{{ Auth::user()->name }}</p>
                    <p class="text-white text-small">Total Units: </p>
                </div>
                <div class="h-10"></div>
                <div class="h-1/2 bg-gray-800 rounded-lg">
                    <p class="text-white p-4">Instructor's Load List</p>
                    <div class=" overflow-y-auto bg-gray-800 rounded-lg">
                        @foreach ($schedules as $schedule)
                            <div class="bg-white m-4 rounded-lg p-4 mb-2">
                                <div>{{ $schedule->roomType }} {{ $schedule->year }}</div>
                                <div class="text-xs">{{ $schedule->code }}
                                    {{ date('g:i A', strtotime($schedule->start)) }} -
                                    {{ date('g:i A', strtotime($schedule->finish)) }}</div>
                                <div class="text-xs">{{ $schedule->instructorName }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <div class="w-3/5 rounded-lg bg-white ml-4 h-1/2" style="border-radius: 5px;">
                <div class="rounded-lg" style="border-radius: 5px;">
                    <div id="calendar" class="p-6"></div>
                </div>
            </div>
        </div>
    @endcan
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            slotMinTime: '8:00:00',
            slotMaxTime: '19:00:00',
            events: @json($events),
        });
        calendar.render();
    });

    function selectSemester(semester) {
        console.log(true)
        $.ajax({
            type: 'GET',
            url: 'dashboard',
            data: {
                _token: '{{ csrf_token() }}',
                search: semester,
            },
            success: function(data) {
                var link = window.location.search
                window.location.href = link == '' ? "dashboard?_token={{ csrf_token() }}&semester=" + semester : link+"&semester="+semester
            },
            error: function(xhr) {
                // Handle the error response, if needed
                console.log(xhr);
            }
        });
    }
    function selectYear(year) {
        $.ajax({
            type: 'GET',
            url: 'dashboard',
            data: {
                _token: '{{ csrf_token() }}',
                search: year,
            },
            success: function(data) {
                var link = window.location.search
                window.location.href = link == '' ? "dashboard?_token={{ csrf_token() }}&year=" + year : link+"&year="+year
            },
            error: function(xhr) {
                // Handle the error response, if needed
                console.log(xhr);
            }
        });
    }
</script>
