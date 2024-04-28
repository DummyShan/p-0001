<x-app-layout>
    <x-slot name="header">
        {{ __('Rooms') }}
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
                <p class="text-white text-2xl">Room Form</p>
                <div class="mt-10 mb-5">
                    <p class="text-white">Room:</p>
                </div>
                <input type="text" class="w-full bg-white rounded-lg" placeholder="">
                <label for="description" style="color:white;">Choose Vehicle</label>
                <select name="description" id="description" class="rounded w-full">
                    <option>
                        Select
                    </option>
                    {{-- @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}">
                            {{ $vehicle->name }}
                        </option>
                    @endforeach --}}
                </select>
                <div class="mt-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md mr-4 w-1/5">Save</button>
                    <button class="px-4 py-2 rounded-md w-1/5">Cancel</button>
                </div>
            </div>
        </div>
        <div class="w-3/5 ml-4">
            <div class="bg-gray-800 p-4 rounded-lg ml-10">
                <p class="text-white text-2xl">Room List</p>
                <div class="mt-10">
                    <div class="flex items-center bg-white rounded-lg p-2">
                        <span class="text-gray-400">
                            <svg class="h-6 w-6 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                        </span>
                        <input type="text" class="w-full bg-transparent focus:outline-none mx-2 rounded-lg"
                            placeholder="Search">
                    </div>
                </div>
                <div class="bg-white rounded-lg p-4 mt-4">
                    <div>
                        <p class="font-bold">Room:</p>
                    </div>
                    <div>
                        <p class="font-bold">Description:</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-4 mt-4">
                    <div>
                        <p class="font-bold">Room:</p>
                    </div>
                    <div>
                        <p class="font-bold">Description:</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-4 mt-4">
                    <div>
                        <p class="font-bold">Room:</p>
                    </div>
                    <div>
                        <p class="font-bold">Description:</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript"></script>

</x-app-layout>
