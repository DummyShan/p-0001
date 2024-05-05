<x-app-layout>
    <x-slot name="header">
        {{ __('Subject') }}
    </x-slot>
    @if (session()->has('success'))
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
    <div class="flex mb-8">
        <div class="pr-10">
            <select name="semester" onchange="selectSemester(this.value)"
                class="w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder="Semester">
                <option value="1st" {{ request()->query('semester') == '1st' ? 'selected' : '' }}>1st Sem</option>
                <option value="2nd" {{ request()->query('semester') == '2nd' ? 'selected' : '' }}>2nd Sem</option>
            </select>
        </div>

        <div>
            <select name="year" onchange="selectYear(this.value)"
                class="w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder="School Year">
                <option value="" {{ request()->query('year') == '' ? 'selected' : '' }}>All</option>
                <option value="1" {{ request()->query('year') == '1' ? 'selected' : '' }}>1st Year</option>
                <option value="2" {{ request()->query('year') == '2' ? 'selected' : '' }}>2nd Year</option>
            </select>
        </div>
    </div>
    <div class="grid bg-white rounded">
        <div class="grid w-full">
            <div class="w-full p-4">
                <p class="text-xl font-semibold">Subjects</p>
            </div>
            <div class="flex flex-row overflow-x-auto w-full p-4">
                @foreach ($subjects as $subject)
                    <div class="flex-shrink-0 w-72 bg-white rounded-lg shadow-md mx-4 border hover:shadow-lg">
                        <!-- Card content -->
                        <div class="p-4">
                            <h2 class="text-xl font-semibold">{{ $subject->code }} {{ $subject->year }}
                                {{ $subject->description }}</h2>
                            <p class="mt-2 text-gray-600">{{ date('g:i A', strtotime($subject->start)) }}
                                {{ date('g:i A', strtotime($subject->finish)) }}</p>
                            <div class="grid grid-cols-2 mt-4">
                                <button onclick="addSubject({{ $subject->id }})"
                                    class="bg-blue-800 text-white rounded shadow-xl hover:shadow-2xl">Add</button>
                                <svg onclick="selectInfo({{ $subject->id }})" class="h-6 w-6 text-red-500 col-end-13"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <circle cx="12" cy="12" r="9" />
                                    <line x1="12" y1="8" x2="12.01" y2="8" />
                                    <polyline points="11 12 12 12 12 16 13 16" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex flex-row overflow-x-auto w-full p-4">
            @foreach ($courses as $course)
                <button class="bg-white rounded-lg w-32 mx-4 p-2 shadow-md hover:shadow-lg border">
                    <h2 class="text-xs">{{ $course->type }}</h2>
                </button>
            @endforeach
        </div>
        <div class="flex flex-row  w-full p-4">
            @if ($instructor != null)
                <div class="flex-shrink-0 w-64 bg-green-300 rounded-lg shadow-md mx-4 border">
                    <div class="p-4">
                        <h2 id="instructor" class="text-base font-semibold">Instructor: {{ $instructor->name }}</h2>
                        <p id="room" class="text-gray-600">Room: {{ $instructor->roomName }}</p>
                        <p id="day" class="text-gray-600">Day: {{ $instructor->day }}</p>
                        <p id="status" class="text-gray-600">Status: {{ $instructor->status }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript"></script>

</x-app-layout>
<script>
    function addSubject(id) {
        let text = "Please Confirm to add the subject\nPress Ok or Cancel.";
        if (confirm(text) == true) {
            $.ajax({
                type: 'POST',
                url: 'add-schedule',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
                success: function(data) {
                    window.location.href = "/subject"
                },
                error: function(xhr) {
                    // Handle the error response, if needed
                    console.log(xhr);
                }
            });
        }
    }

    function selectInfo(id) {
        $.ajax({
            type: 'GET',
            url: 'subject',
            data: {
                _token: '{{ csrf_token() }}',
                search: id,
            },
            success: function(data) {
                window.location.href = "?_token={{ csrf_token() }}&search=" + id
            },
            error: function(xhr) {
                // Handle the error response, if needed
                console.log(xhr);
            }
        });
    }

    function selectSemester(semester) {
        console.log(true)
        $.ajax({
            type: 'GET',
            url: 'subject',
            data: {
                _token: '{{ csrf_token() }}',
                search: semester,
            },
            success: function(data) {
                var link = window.location.search
                // window.location.href = link == '' ? "?_token={{ csrf_token() }}&semester=" + semester : link+"&semester="+semester
                window.location.href = "?_token={{ csrf_token() }}&semester=" + semester
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
            url: 'subject',
            data: {
                _token: '{{ csrf_token() }}',
                search: year,
            },
            success: function(data) {
                var link = window.location.search
                // window.location.href = link == '' ? "?_token={{ csrf_token() }}&year=" + year : link+"&year="+year
                window.location.href = "?_token={{ csrf_token() }}&year=" + year
            },
            error: function(xhr) {
                // Handle the error response, if needed
                console.log(xhr);
            }
        });
    }
</script>
