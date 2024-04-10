<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- <div class="px-6 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-3xl p-8 mb-5">
                <h1 class="text-3xl font-bold mb-10">Messaging ID framework development for the marketing branch</h1>
                <div class="flex items-center justify-between">
                    <div class="flex items-stretch">
                        <div class="text-gray-400 text-xs">Members<br>connected</div>
                        <div class="h-100 border-l mx-4"></div>
                        <div class="flex flex-nowrap -space-x-3">
                            <div class="h-9 w-9">
                                <img class="object-cover w-full h-full rounded-full" src="https://ui-avatars.com/api/?background=random">
                            </div>
                            <div class="h-9 w-9">
                                <img class="object-cover w-full h-full rounded-full" src="https://ui-avatars.com/api/?background=random">
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <button type="button" class="inline-flex items-center justify-center h-9 px-3 rounded-xl border hover:border-gray-400 text-gray-800 hover:text-gray-900 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chat-fill" viewBox="0 0 16 16">
                                <path d="M8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6-.097 1.016-.417 2.13-.771 2.966-.079.186.074.394.273.362 2.256-.37 3.597-.938 4.18-1.234A9.06 9.06 0 0 0 8 15z" />
                            </svg>
                        </button>
                        <button type="button" class="inline-flex items-center justify-center h-9 px-5 rounded-xl bg-gray-900 text-gray-300 hover:text-white text-sm font-semibold transition">
                            Open
                        </button>
                    </div>
                </div>

                <hr class="my-10">

                <div class="grid grid-cols-2 gap-x-20">
                    <div>
                        <h2 class="text-2xl font-bold mb-4">Stats</h2>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <div class="p-4 bg-green-100 rounded-xl">
                                    <div class="font-bold text-xl text-gray-800 leading-none">Good day, <br>Kristin</div>
                                    <div class="mt-5">
                                        <button type="button" class="inline-flex items-center justify-center py-2 px-3 rounded-xl bg-white text-gray-800 hover:text-green-500 text-sm font-semibold transition">
                                            Start tracking
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 bg-yellow-100 rounded-xl text-gray-800">
                                <div class="font-bold text-2xl leading-none">20</div>
                                <div class="mt-2">Tasks finished</div>
                            </div>
                            <div class="p-4 bg-yellow-100 rounded-xl text-gray-800">
                                <div class="font-bold text-2xl leading-none">5,5</div>
                                <div class="mt-2">Tracked hours</div>
                            </div>
                            <div class="col-span-2">
                                <div class="p-4 bg-purple-100 rounded-xl text-gray-800">
                                    <div class="font-bold text-xl leading-none">Your daily plan</div>
                                    <div class="mt-2">5 of 8 completed</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4">Your tasks today</h2>

                        <div class="space-y-4">
                            <div class="p-4 bg-white border rounded-xl text-gray-800 space-y-2">
                                <div class="flex justify-between">
                                    <div class="text-gray-400 text-xs">Number 10</div>
                                    <div class="text-gray-400 text-xs">4h</div>
                                </div>
                                <a href="javascript:void(0)" class="font-bold hover:text-yellow-800 hover:underline">Blog and social posts</a>
                                <div class="text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="text-gray-800 inline align-middle mr-1" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>Deadline is today
                                </div>
                            </div>
                            <div class="p-4 bg-white border rounded-xl text-gray-800 space-y-2">
                                <div class="flex justify-between">
                                    <div class="text-gray-400 text-xs">Grace Aroma</div>
                                    <div class="text-gray-400 text-xs">7d</div>
                                </div>
                                <a href="javascript:void(0)" class="font-bold hover:text-yellow-800 hover:underline">New campaign review</a>
                                <div class="text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="text-gray-800 inline align-middle mr-1" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>New feedback
                                </div>
                            </div>
                            <div class="p-4 bg-white border rounded-xl text-gray-800 space-y-2">
                                <div class="flex justify-between">
                                    <div class="text-gray-400 text-xs">Petz App</div>
                                    <div class="text-gray-400 text-xs">2h</div>
                                </div>
                                <a href="javascript:void(0)" class="font-bold hover:text-yellow-800 hover:underline">Cross-platform and browser QA</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <div class="py-12" id="dashboard-message">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> -->

    <div class="py-12" id="dashboard-message">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center space-x-4">
                    <div>
                        <!-- Dropdown to select task group -->
                        <select id="task-group-dropdown" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Task Group</option>
                            <!-- Replace this with dynamic options loaded from backend -->
                            @foreach ($taskGroups as $taskGroup)
                            <option value="{{ $taskGroup->id }}">{{ $taskGroup->name }}</option>
                            @endforeach
                            <!-- Add more options as needed -->
                        </select>
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-4">
                <!-- Dynamic List Column -->
                <div id="card-1" class="card bg-yellow-100 rounded-md p-4 mb-4">
                    <!-- Add List Button -->
                    <button id="add-list-btn" class="add-list-btn">+ Add List</button>
                    <!-- List Label Input -->
                    <div id="list-input" class="hidden list-input">
                        <input type="text" id="list-label" class="list-label" placeholder="Enter List Label">
                        <!-- <button id="add-list-label-btn">Add Label</button> -->
                    </div>
                    <!-- List Title -->
                    <h2 class="list-title font-semibold text-lg mb-4" style="display: none;"></h2>

                    <!-- Task List -->
                    <ul class="task-list"></ul>
                    <!-- Task Input -->
                    <div class="task-input hidden">
                        <input type="text" class="task-label" placeholder="Enter Task">
                        <!-- <button id="add-task-label-btn">Add Task</button> -->
                    </div>
                    <!-- Add Task Button -->
                    <button class="add-task-btn hidden">+ Add Task</button>
                </div>
                <!-- Other columns -->
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-4">
                <!-- To Do Column -->
                <div class="bg-yellow-100 p-4 rounded-md">
                    <h2 class="font-semibold text-lg mb-4">To Do</h2>
                    <ul class="sortable" id="todo-list" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <li class="draggable bg-white rounded-md p-2 mb-4" draggable="true" ondragstart="drag(event)" id="task1">Task 1</li>
                        <li class="draggable bg-white rounded-md p-2 mb-4" draggable="true" ondragstart="drag(event)" id="task2">Task 2</li>
                    </ul>
                </div>

                <!-- In Progress Column -->
                <div class="bg-purple-100 p-4 rounded-md">
                    <h2 class="font-semibold text-lg mb-4">In Progress</h2>
                    <ul class="sortable" id="in-progress-list" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <li class="draggable bg-white rounded-md p-2 mb-4" draggable="true" ondragstart="drag(event)" id="task3">Task 3</li>
                    </ul>
                </div>

                <!-- Completed Column -->
                <div class="bg-green-100 p-4 rounded-md">
                    <h2 class="font-semibold text-lg mb-4">Completed</h2>
                    <ul class="sortable" id="completed-list" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <!-- Add tasks for Completed column here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let draggedItem = null;

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        draggedItem = ev.target;
    }

    function drop(ev) {
        ev.preventDefault();
        if (draggedItem) {
            // Check if the drop target is a list itself
            if (ev.target.tagName === 'UL') {
                // Append the dragged item to the target list
                ev.target.appendChild(draggedItem);
            }
            // Check if the drop target is a list item
            else if (ev.target.tagName === 'LI') {
                // Append the dragged item before or after the target item
                if (ev.clientY < ev.target.getBoundingClientRect().top + ev.target.offsetHeight / 2) {
                    ev.target.parentNode.insertBefore(draggedItem, ev.target); // Append before the target
                } else {
                    ev.target.parentNode.insertBefore(draggedItem, ev.target.nextSibling); // Append after the target
                }
            }
            console.log('Task moved');
            draggedItem = null;
        }
    }


    ///---------------
    // Function to generate a unique column ID
    function generateColumnId() {
        return 'card-' + ($('.card').length + 1);
    }

    // Function to add a new column
    function addColumn() {
        var newColumnId = generateColumnId();
        var newColumn = `
                <div id="${newColumnId}" class="card bg-yellow-100 rounded-md p-4 mb-4">
                <button id="add-list-btn" class="add-list-btn">+ Add List</button>
                    <div id="list-input" class="hidden list-input">
                        <input type="text" id="list-label" class="list-label" placeholder="Enter List Label">
                    </div>
                    <h2 class="list-title font-semibold text-lg mb-4" style="display: none;"></h2>
                    <ul class="task-list"></ul>
                    <div class="task-input hidden">
                        <input type="text" class="task-label" placeholder="Enter Task">
                    </div>
                    <button class="add-task-btn hidden">+ Add Task</button>
                </div>
            `;
        $('.card').last().after(newColumn);
    }

    // Add List Button Click Event
    // $('#add-list-btn').click(function() {
    //     $('#add-list-btn').hide();
    //     $('#list-input').show();
    //     $('#list-label').focus();
    // });

    // Add List Button Click Event
    $(document).on('click', '.add-list-btn', function() {
        $(this).hide();
        $(this).closest('.card').find('.list-input').show();
        $(this).closest('.card').find('.list-label').focus();
    });

    // // Add List Label Input Keyup Event
    // $('#list-label').keyup(function(event) {
    //     if (event.keyCode === 13) {
    //         var label = $(this).val().trim();
    //         if (label !== '') {
    //             $('#list-title').text(label).show();
    //             $('#list-input').hide();
    //             $('#add-task-btn').removeClass('hidden');
    //             addColumn();
    //         }
    //     }
    // });

    // Add List Label Input Keyup Event
    $(document).on('keyup', '.list-label', function(event) {
        if (event.keyCode === 13) {
            var label = $(this).val().trim();
            if (label !== '') {
                var card = $(this).closest('.card');
                card.find('.list-title').text(label).show();
                card.find('.list-input').hide();
                card.find('.add-task-btn').removeClass('hidden');
                addColumn();
            }
        }
    });

    // // Add Task Button Click Event
    // $('#add-task-btn').click(function() {
    //     $('#task-input').show();
    //     $('#task-label').focus();
    // });

    // // Task Input Field Keyup Event
    // $('#task-label').keyup(function(event) {
    //     if (event.keyCode === 13) {
    //         var task = $(this).val().trim();
    //         if (task !== '') {
    //             var taskItem = $('<li class="draggable bg-white rounded-md p-2 mb-4"></li>').text(task);
    //             $('#task-list').append(taskItem);
    //             $(this).val('');
    //             $('#task-input').hide();
    //         }
    //     }
    // });

    // Task Button Click Event
    $(document).on('click', '.add-task-btn', function() {
        var card = $(this).closest('.card');
        card.find('.task-input').show();
        card.find('.task-label').focus();
    });

    // Task Input Field Keyup Event
    $(document).on('keyup', '.task-label', function(event) {
        if (event.keyCode === 13) {
            var task = $(this).val().trim();
            if (task !== '') {
                var card = $(this).closest('.card');
                var taskItem = $('<li class="draggable bg-white rounded-md p-2 mb-4"></li>').text(task);
                card.find('.task-list').append(taskItem);
                $(this).val('');
                card.find('.task-input').hide();
            }
        }
    });
</script>