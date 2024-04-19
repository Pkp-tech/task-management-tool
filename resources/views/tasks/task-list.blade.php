<div class="py-12 overflow-x-auto no-scrollbar">
    <div class="flex space-x-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Dynamic List Column -->
        @foreach ($statusColumns as $statusColumn)
        <div class="card min-w-[400px] max-h-[400px] overflow-y-auto" data-status-column-id="{{ $statusColumn->id }}" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="bg-yellow-100 p-4 rounded-md mb-4">
                <!-- List Title -->
                <div class="flex justify-between items-center mb-4">
                    <div id="list-input" class="hidden list-input">
                        <input type="text" class="list-status-column" placeholder="Enter List Title">
                    </div>
                    <h2 class="list-title font-semibold text-lg">{{ $statusColumn->name }}</h2>
                    <!-- More Options Button -->
                    <div class="relative">
                        <button class="more-options-btn">⋮</button>
                        <!-- More Options Menu -->
                        <div class="more-options-menu hidden absolute right-0 mt-2 bg-white shadow-lg rounded z-100 p-2">
                            <ul>
                                <li><button class="edit-status-column-btn" data-status-column-id="{{ $statusColumn->id }}">Edit</button></li>
                                <li><button class="delete-status-column-btn" data-status-column-id="{{ $statusColumn->id }}" data-status-column-title="{{ $statusColumn->name }}">Delete</button></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Task List -->
                <ul class="task-list" ondrop="drop(event)" ondragover="allowDrop(event)">
                    @foreach ($statusColumn->tasks as $task)
                    <li class="draggable bg-white rounded-md p-2 mb-4 flex justify-between items-center" data-task-id="{{ $task->id }}" draggable="true" ondragstart="drag(event)">
                        <div class="flex flex-col">
                            <!-- Task title -->
                            <span>{{ $task->title }}</span>
                            <!-- Task description (with truncation and ellipsis) -->
                            <span class="task-description text-sm text-gray-600 overflow-hidden whitespace-nowrap overflow-ellipsis">
                                {{ \Str::limit($task->description, 40, '...') }}
                            </span>

                            <div class="task-labels flex flex-wrap gap-1 mt-1">
                                @foreach ($task->labels as $label)
                                <span class="task-label text-sm text-blue-600 border border-blue-600 rounded px-1">
                                    {{ $label->name }}
                                </span>
                                @endforeach
                            </div>

                        </div>

                        <!-- Three-dot menu for more options -->
                        <div class="relative">
                            <button class="more-options-btn">⋮</button>
                            <div class="more-options-menu hidden absolute right-0 mt-2 bg-white shadow-lg rounded z-100 p-2">
                                <ul>
                                    <li><button class="edit-task-btn" data-task-id="{{ $task->id }}">Edit</button></li>
                                    <li><button class="delete-task-btn" data-task-id="{{ $task->id }}">Delete</button></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>

                <!-- Add Task Button -->
                <button class="add-task-btn text-yellow-700">+ Add Task</button>

                <!-- Task Input -->
                <div class="task-input hidden">
                    <input type="text" class="task-status" placeholder="Enter Task">
                </div>
            </div>
        </div>
        @endforeach

        <!-- Empty card for adding a new list -->
        <div class="card min-w-[400px] max-h-[400px] overflow-y-auto">
            <div class="bg-yellow-100 p-4 rounded-md mb-4">
                <!-- Add List Button -->
                <button id="add-list-btn" class="add-list-btn text-yellow-700">
                    @if($statusColumns->isEmpty())
                    + Add List
                    @else
                    + Add Another List
                    @endif
                </button>

                <!-- List Status Column Input -->
                <div class="flex justify-between items-center mb-4">
                    <div id="list-input" class="list-input" style="display: none;">
                        <input type="text" class="list-status-column" placeholder="Enter List Title">
                    </div>
                    <h2 class="list-title font-semibold text-lg" style="display: none;"></h2>
                    <!-- More Options Button -->
                    <div class="relative">
                        <button class="more-options-btn hidden">⋮</button>
                        <!-- More Options Menu -->
                        <div class="more-options-menu hidden absolute right-0 mt-2 bg-white shadow-lg rounded z-100 p-2">
                            <ul>
                                <li><button class="edit-status-column-btn" data-status-column-id="">Edit</button></li>
                                <li><button class="delete-status-column-btn" data-status-column-id="" data-status-column-title="">Delete</button></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Task List -->
                <ul class="task-list"></ul>
                <!-- Task Input -->
                <div class="task-input hidden">
                    <input type="text" class="task-status" placeholder="Enter Task">
                </div>
                <!-- Add Task Button -->
                <button class="add-task-btn text-yellow-700 hidden">+ Add Task</button>
            </div>
        </div>
    </div>

    @include('tasks.partials.edit-task-modal' , ['labels' => $labels])
    @include('tasks.partials.delete-task-modal')
    @include('tasks.partials.delete-status-column-modal')

    <script>
        let draggedItem = null;

        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            draggedItem = ev.target;
        }

        function drop(event) {
            event.preventDefault();

            // Ensure that the dragged item is not null
            if (draggedItem) {
                // Get the target element where the item is being dropped
                const target = event.target;

                // Find the parent UL element if the target is not a UL element itself
                let ulElement;
                if (target.tagName === 'UL') {
                    ulElement = target;
                } else if (target.tagName === 'DIV') {
                    // Event target is a DIV, find the UL element within it using querySelector
                    ulElement = target.querySelector('ul.task-list');
                } else {
                    ulElement = target.closest('ul.task-list');
                }

                // Check if the UL element exists and if it has the class 'task-list'
                if (ulElement && ulElement.classList.contains('task-list')) {
                    // Append the dragged item to the UL element
                    ulElement.appendChild(draggedItem);

                    // Retrieve the data-status-column-id of the new list (drop target)
                    let newStatusColumnId = ulElement.closest('.card').getAttribute('data-status-column-id');

                    // Retrieve the data-task-id of the dragged element (task)
                    let taskId = draggedItem.getAttribute('data-task-id');

                    // Make an AJAX request to update the task's status_column_id on the server side
                    updateTaskStatus(taskId, newStatusColumnId);

                    console.log('Task moved to new list.');
                }

                // Reset the dragged item
                draggedItem = null;
            }
        }

        // Function to update the task's status_column_id on the server side
        function updateTaskStatus(taskId, newStatusColumnId) {
            // Perform an AJAX request to update the task's status_column_id
            $.ajax({
                url: `/tasks/${taskId}/update-status`, // Endpoint to update task's status_column_id
                type: 'PUT', // Use PUT method for updating data
                data: {
                    status_column_id: newStatusColumnId,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    // Handle successful response (e.g., update the UI)
                    console.log('Task staus updated successfully:', response);
                    // Optionally refresh the page or UI
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error('Error updating task status_column_id:', error);
                    // Optionally display an error message to the user
                }
            });
        }
    </script>