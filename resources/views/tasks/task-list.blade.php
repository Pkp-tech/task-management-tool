<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 gap-4">
            <!-- Dynamic List Column -->
            @foreach ($labels as $label)
            <div class="card bg-yellow-100 rounded-md p-4 mb-4" data-label-id="{{ $label->id }}">
                <!-- List Title -->
                <h2 class="list-title font-semibold text-lg mb-4">{{ $label->name }}</h2>

                <!-- Task List -->
                <ul class="task-list">
                    @foreach ($label->tasks as $task)
                    <li class="draggable bg-white rounded-md p-2 mb-4 flex justify-between items-center">
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
                <button class="add-task-btn">+ Add Task</button>

                <!-- Task Input -->
                <div class="task-input hidden">
                    <input type="text" class="task-label" placeholder="Enter Task">
                </div>
            </div>
            @endforeach

            <!-- Empty card for adding a new list -->
            <div class="card bg-yellow-100 rounded-md p-4 mb-4">
                <!-- Add List Button -->
                <button id="add-list-btn" class="add-list-btn">
                    @if($labels->isEmpty())
                    + Add List
                    @else
                    + Add Another List
                    @endif
                </button>
                <!-- List Label Input -->
                <div id="list-input" class="hidden list-input">
                    <input type="text" id="list-label" class="list-label" placeholder="Enter List Label">
                </div>
                <!-- List Title -->
                <h2 class="list-title font-semibold text-lg mb-4" style="display: none;"></h2>

                <!-- Task List -->
                <ul class="task-list"></ul>
                <!-- Task Input -->
                <div class="task-input hidden">
                    <input type="text" class="task-label" placeholder="Enter Task">
                </div>
                <!-- Add Task Button -->
                <button class="add-task-btn hidden">+ Add Task</button>
            </div>

            <!-- Other columns -->
        </div>
    </div>
</div>

@include('tasks.partials.edit-task-modal')
@include('tasks.partials.delete-task-modal')