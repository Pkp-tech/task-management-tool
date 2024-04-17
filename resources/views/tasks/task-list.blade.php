<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-x-auto">
            <div class="grid grid-cols-3 gap-4">
                <!-- Dynamic List Column -->
                @foreach ($labels as $label)
                <div class="card bg-yellow-100 rounded-md p-4 mb-4" data-label-id="{{ $label->id }}" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <!-- List Title -->
                    <div class="flex justify-between items-center mb-4">
                        <div id="list-input" class="hidden list-input">
                            <input type="text" id="list-label" class="list-label" placeholder="Enter List Title">
                        </div>
                        <h2 class="list-title font-semibold text-lg">{{ $label->name }}</h2>
                        <!-- More Options Button -->
                        <div class="relative">
                            <button class="more-options-btn">⋮</button>
                            <!-- More Options Menu -->
                            <div class="more-options-menu hidden absolute right-0 mt-2 bg-white shadow-lg rounded z-100 p-2">
                                <ul>
                                    <li><button class="edit-label-btn" data-label-id="{{ $label->id }}">Edit</button></li>
                                    <li><button class="delete-label-btn" data-label-id="{{ $label->id }}" data-label-title="{{ $label->name }}">Delete</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Task List -->
                    <ul class="task-list" ondrop="drop(event)" ondragover="allowDrop(event)">
                        @foreach ($label->tasks as $task)
                        <li class="draggable bg-white rounded-md p-2 mb-4 flex justify-between items-center" data-task-id="{{ $task->id }}" draggable="true" ondragstart="drag(event)">
                            <!-- Task title -->
                            <span>{{ $task->title }}</span>

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
                @endforeach

                <!-- Empty card for adding a new list -->
                <div class="card bg-yellow-100 rounded-md p-4 mb-4">
                    <!-- Add List Button -->
                    <button id="add-list-btn" class="add-list-btn text-yellow-700">
                        @if($labels->isEmpty())
                        + Add List
                        @else
                        + Add Another List
                        @endif
                    </button>

                    <!-- List Label Input -->
                    <div class="flex justify-between items-center mb-4">
                        <div id="list-input" class="hidden list-input">
                            <input type="text" id="list-label" class="list-label" placeholder="Enter List Title">
                        </div>
                        <h2 class="list-title font-semibold text-lg" style="display: none;"></h2>
                        <!-- More Options Button -->
                        <div class="relative">
                            <button class="more-options-btn hidden">⋮</button>
                            <!-- More Options Menu -->
                            <div class="more-options-menu hidden absolute right-0 mt-2 bg-white shadow-lg rounded z-100 p-2">
                                <ul>
                                    <li><button class="edit-label-btn" data-label-id="">Edit</button></li>
                                    <li><button class="delete-label-btn" data-label-id="" data-label-title="">Delete</button></li>
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
    </div>
</div>

@include('tasks.partials.edit-task-modal')
@include('tasks.partials.delete-task-modal')
@include('tasks.partials.delete-label-modal')

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

                // Retrieve the data-label-id of the new list (drop target)
                let newLabelId = ulElement.closest('.card').getAttribute('data-label-id');

                // Retrieve the data-task-id of the dragged element (task)
                let taskId = draggedItem.getAttribute('data-task-id');

                // Make an AJAX request to update the task's label_id on the server side
                updateTaskStatus(taskId, newLabelId);

                console.log('Task moved to new list.');
            }

            // Reset the dragged item
            draggedItem = null;
        }
    }

    // Function to update the task's label_id on the server side
    function updateTaskStatus(taskId, newLabelId) {
        // Perform an AJAX request to update the task's label_id
        $.ajax({
            url: `/tasks/${taskId}/update-status`, // Endpoint to update task's label_id
            type: 'PUT', // Use PUT method for updating data
            data: {
                label_id: newLabelId,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                // Handle successful response (e.g., update the UI)
                console.log('Task staus updated successfully:', response);
                // Optionally refresh the page or UI
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error updating task label_id:', error);
                // Optionally display an error message to the user
            }
        });
    }
</script>