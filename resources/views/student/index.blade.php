<x-app-layout>
    <x-slot name="header">
        {{ __('Student') }}
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
                <form action="{{ route('student.store') }}" method="POST">
                    @csrf
                    <p class="text-white text-2xl">Student Form</p>
                    <div class="mt-10 mb-5">
                        <label for="user_id" class="text-white">Student</label>
                        <select name="user_id" id="user_id" class="rounded w-full">
                            <option>
                                Select
                            </option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-5 mb-5">
                        <p class="text-white">ID No.:</p>
                        <input type="text" name="idNo" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mt-5 mb-5">
                        <p class="text-white">Email:</p>
                        <input type="email" name="email" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mt-5 mb-5">
                        <p class="text-white">Contact:</p>
                        <input type="number" name="contact" class="w-full bg-white rounded-lg" placeholder="">
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
                <p class="text-white text-2xl">Student List</p>
                <div class="mt-10">
                    <form action="{{ route('student.index') }}" method="GET">
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
                                <p class="font-bold">Name: {{ $list->name }}</p>
                            </div>
                            <div>
                                <p class="font-bold">ID No.: {{ $list->idNo }}</p>
                            </div>
                            <div>
                                <p class="font-bold">Email: {{ $list->email }}</p>
                            </div>
                            <div>
                                <p class="font-bold">Contact: {{ $list->contact }}</p>
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
