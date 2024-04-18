<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Check for status and error messages -->
    @if (session('status'))
    <!-- Display the success message -->
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    @if (session('error'))
    <!-- Display the error message -->
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="py-12" id="dashboard-message">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center space-x-4">
                    <div class="px-6">
                        @if ($taskGroups->isEmpty())
                        <div class="text-gray-600 dark:text-gray-400">No task groups available. Please create a task group to add tasks.</div>
                        @else
                        <!-- Dropdown to select task group -->
                        <select id="task-group-dropdown" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mx-6">
                            <!-- Replace this with dynamic options loaded from backend -->
                            @foreach ($taskGroups as $taskGroup)
                            <option value="{{ $taskGroup->id }}" {{ $selectedTaskGroupId == $taskGroup->id ? 'selected' : '' }}>
                                {{ $taskGroup->name }}
                            </option> @endforeach
                            <!-- Add more options as needed -->
                        </select>
                        @endif
                    </div>
                    <div>
                        <!-- @if (Route::has('task-group'))
                        <a class="underline text-md text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 mx-4" href="{{ route('task-group') }}">
                            {{ __('Add new task gorup?') }}
                        </a>
                        @endif -->
                        <!-- Button to add task group -->
                        <a href="{{ route('task-group.add') }}" class="inline-block px-4 py-2 bg-green-300 text-white rounded-lg hover:bg-green-400 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            Add New Task Group
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include task list  -->
    @include('tasks.task-list', ['labels' => $labels])

</x-app-layout>