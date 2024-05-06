<x-app-layout>
    <x-slot name="header">
        {{ __('Course') }}
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
    <div class="flex">
        <div class="w-2/5">
            <div class="bg-gray-800 p-4 rounded-lg h-500">
                <form action="{{ route('course.store') }}" method="POST">
                    @csrf
                    <p class="text-white text-2xl mb-4">Course Form</p>
                    <label for="type" class="text-white">Course List</label>
                    <select name="type" id="type" class="rounded w-full mb-2">
                        <option>
                            Select
                        </option>
                        <option value="BSIT">
                            BSIT
                        </option>
                        <option value="BSCS">
                            BSCS
                        </option>
                        <option value="BSIS">
                            BSIS
                        </option>
                        <option value="BSEMC">
                            BSEMC
                        </option>
                    </select>
                    <div class="mb-2">
                        <p class="text-white">Year:</p>
                        <input type="number" name="year" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Subject:</p>
                        <input type="text" name="subject" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Subject Code:</p>
                        <input type="text" name="subjectCode" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-2">
                        <label for="room_id" class="text-white">Room</label>
                        <select name="room_id" id="room_id" class="rounded w-full mb-2">
                            <option>
                                Select
                            </option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Description:</p>
                        <input type="text" name="description" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-2">
                        <label for="status" class="text-white">Staus</label>
                        <select name="status" id="status" class="rounded w-full mb-2">
                            <option>
                                Select
                            </option>
                            <option value="available">
                                Available
                            </option>
                            <option value="N/A">
                                N/A
                            </option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Units:</p>
                        <input type="number" name="unit" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-2">
                        <label for="day" class="text-white">Day</label>
                        <select name="day" id="day" class="rounded w-full mb-2">
                            <option>
                                Select
                            </option>
                            <option value="Monday">
                                Monday
                            </option>
                            <option value="Tuesday">
                                Tuesday
                            </option>
                            <option value="Wednesday">
                                Wednesday
                            </option>
                            <option value="Thursday">
                                Thursday
                            </option>
                            <option value="Friday">
                                Friday
                            </option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Time Start:</p>
                        <input type="time" name="time_start" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Time End:</p>
                        <input type="time" name="time_end" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Block:</p>
                        <input type="text" name="block" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mt-4">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md mr-4 w-1/5">Save</button>
                        <button type="reset"
                            class="px-4 py-2 rounded-md w-1/5 text-white hover:bg-red-800">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-3/5 ml-4">
            <div class="bg-gray-800 p-4 rounded-lg ml-10">
                <p class="text-white text-2xl">Course List</p>
                <div class="mt-10">
                    <form action="{{ route('course.index') }}" method="GET">
                        <div class="flex items-center bg-white rounded-lg p-2">
                            @csrf
                            <button type="submit">
                                <svg class="h-6 w-6 text-blue-500 hover:text-blue-800" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                            </button>
                            <input type="search" name="search"
                                class="w-full bg-transparent focus:outline-none mx-2 rounded-lg" placeholder="Search">
                        </div>
                    </form>
                </div>
                <div class="overflow-y-auto">
                    @foreach ($lists as $list)
                        <div class="bg-white rounded-lg p-4 mt-4">
                            <div>
                                <p class="font-bold">Course Type: {{ $list->type }}</p>
                            </div>
                            {{-- <div>
                                <p class="font-bold">Year:
                                    {{ $list->year == '2' || $list->year == '3' || $list->year == '4' ? $list->year . 'nd' : $list->year . 'st' }}
                                </p>
                            </div> --}}
                            <div>
                                <p class="font-bold">Subject: {{ $list->subject }}</p>
                            </div>
                            <div>
                                <p class="font-bold">Subject Code: {{ $list->subjectCode }}</p>
                            </div>
                            <div>
                                <p class="font-bold">Room: {{ $list->name }}</p>
                            </div>
                            <div>
                                <p class="font-bold">Description: {{ $list->description }}</p>
                            </div>
                            <div>
                                <p class="font-bold">Block: {{ $list->block }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript"></script>

</x-app-layout>
