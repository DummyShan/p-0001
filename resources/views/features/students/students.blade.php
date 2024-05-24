<x-app-layout>
    <x-slot name="header">
        {{ __('Users') }}
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

    @if ($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif

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

    <div>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf()
            <input name="name" placeholder="Name" />
            <input name="email" placeholder="Email" />
            <select name="role" id="role">
                <option value="">Select Role</option>
                <option value="Student">Student</option>
                <option value="Instructor">Instructor</option>
            </select>
            <button>Create User</button>
        </form>
    </div>

    <div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    @if ($user->email !== 'super@mail.com')
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles[0]->title }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
