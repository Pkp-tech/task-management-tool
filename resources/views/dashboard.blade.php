<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" id="dashboard-message">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center space-x-4">
                    <div>
                        <!-- Dropdown to select task group -->
                        <select id="task-group-dropdown" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <!-- Replace this with dynamic options loaded from backend -->
                            @foreach ($taskGroups as $taskGroup)
                            <option value="{{ $taskGroup->id }}" {{ $selectedTaskGroupId == $taskGroup->id ? 'selected' : '' }}>
                                {{ $taskGroup->name }}
                            </option> @endforeach
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

    <!-- Include task list  -->
    @include('tasks.task-list')

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
    // function generateColumnId() {
    //     return 'card-' + ($('.card').length + 1);
    // }

    // // Function to add a new column
    // function addColumn() {
    //     var newColumnId = generateColumnId();
    //     var newColumn = `
    //             <div id="${newColumnId}" class="card bg-yellow-100 rounded-md p-4 mb-4">
    //             <button id="add-list-btn" class="add-list-btn">+ Add List</button>
    //                 <div id="list-input" class="hidden list-input">
    //                     <input type="text" id="list-label" class="list-label" placeholder="Enter List Label">
    //                 </div>
    //                 <h2 class="list-title font-semibold text-lg mb-4" style="display: none;"></h2>
    //                 <ul class="task-list"></ul>
    //                 <div class="task-input hidden">
    //                     <input type="text" class="task-label" placeholder="Enter Task">
    //                 </div>
    //                 <button class="add-task-btn hidden">+ Add Task</button>
    //             </div>
    //         `;
    //     $('.card').last().after(newColumn);
    // }

    // // Add List Button Click Event
    // $(document).on('click', '.add-list-btn', function() {
    //     $(this).hide();
    //     $(this).closest('.card').find('.list-input').show();
    //     $(this).closest('.card').find('.list-label').focus();
    // });

    // // Add List Label Input Keyup Event
    // $(document).on('keyup', '.list-label', function(event) {
    //     if (event.keyCode === 13) {
    //         var label = $(this).val().trim();
    //         if (label !== '') {
    //             var card = $(this).closest('.card');
    //             card.find('.list-title').text(label).show();
    //             card.find('.list-input').hide();
    //             card.find('.add-task-btn').removeClass('hidden');
    //             addColumn();
    //         }
    //     }
    // });

    // // Task Button Click Event
    // $(document).on('click', '.add-task-btn', function() {
    //     var card = $(this).closest('.card');
    //     card.find('.task-input').show();
    //     card.find('.task-label').focus();
    // });

    // // Task Input Field Keyup Event
    // $(document).on('keyup', '.task-label', function(event) {
    //     if (event.keyCode === 13) {
    //         var task = $(this).val().trim();
    //         if (task !== '') {
    //             var card = $(this).closest('.card');
    //             var taskItem = $('<li class="draggable bg-white rounded-md p-2 mb-4"></li>').text(task);
    //             card.find('.task-list').append(taskItem);
    //             $(this).val('');
    //             card.find('.task-input').hide();
    //         }
    //     }
    // });
</script>