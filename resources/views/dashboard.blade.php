<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <!-- Check for status and error messages -->
    @if (session('status'))
    <!-- Display the success message -->
    <div class="py-2" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
        <div class="flex items-center justify-center">
            <p class="text-sm text-gray-600 dark:text-gray-400 ml-4">{{ session('status') }}</p>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div class="py-2" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
        <div class="flex items-center justify-center">
            <p x-data="{ show: true }" class="text-sm text-gray-600 dark:text-gray-400 ml-4">{{ session('status')}}</p>
        </div>
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
    @if (!empty($selectedTaskGroupId))
    @include('tasks.task-list', ['labels' => $labels])
    @endif

</x-app-layout>