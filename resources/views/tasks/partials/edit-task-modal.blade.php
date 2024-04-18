<!-- Modal -->
<div id="edit-task-modal" class="task-modal fixed z-50 inset-0 bg-gray-900 bg-opacity-75 hidden">
    <div class="flex justify-center items-center h-full mt-6">
        <div class="bg-white rounded-md p-6 max-h-screen overflow-y-auto my-10">
            <!-- Close button (X) -->
            <button class="modal-close absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>

            <h2 id="modal-title" class="text-lg font-bold mb-4">Edit Task</h2>

            <!-- Form inside modal -->
            <form method="post" action="{{ route('task.update') }}" class="space-y-4" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="edit-task-error-message text-red-500 hidden">
                    <!-- Error messages will be displayed here -->
                </div>


                <!-- Task Data Section -->
                <div class="bg-blue-100 p-4 rounded-md mb-4">
                    <h3 class="text-sm font-semibold mb-2">Task Details:</h3>
                    <!-- Task Title Input with Label -->
                    <div class="mb-4 flex items-center space-x-4">
                        <label for="task-title" class="text-sm font-semibold">Title:</label>
                        <input type="text" id="task-title" name="task_title" class="border rounded flex-1 p-2" placeholder="Task Title" required>
                    </div>

                    <!-- Task Description Input with Label -->
                    <div class="flex items-center space-x-4">
                        <label for="task-description" class="text-sm font-semibold">Description:</label>
                        <textarea id="task-description" name="task_description" class="border rounded flex-1 p-2" placeholder="Task Description (Optional)"></textarea>
                    </div>

                    <!-- Hidden input for task ID (edit or delete case) -->
                    <input type="hidden" id="task-id" name="task_id" value="">
                </div>

                <!-- Labels Section -->
                <div class="bg-yellow-100 p-4 rounded-md mb-4">
                    <h3 class="text-sm font-semibold mb-2">Labels:</h3>
                    <div class="label-checkboxes grid grid-cols-3 gap-4">
                        <!-- Loop through labels and display as checkboxes -->
                        @foreach ($labels as $label)
                        <div class="label flex items-center space-x-2 mb-2">
                            <input type="checkbox" id="label-{{ $label->id }}" name="label_ids[]" value="{{ $label->id }}">
                            <label for="label-{{ $label->id }}">{{ $label->name }}</label>
                            <!-- Trash icon -->
                            <i class="fas fa-trash text-red-500 remove-label-btn" data-label-id="{{ $label->id }}"></i>
                        </div>
                        @endforeach
                    </div>

                    <!-- Section to add a new label -->
                    <div class="mt-4 flex items-center space-x-4">
                        <input type="text" id="new-label-input" class="new-label-input border rounded flex-1 p-2" placeholder="Enter new label">
                        <button type="button" class="add-new-label-btn bg-green-500 text-white rounded px-4 py-2">Add Label</button>
                    </div>
                </div>

                <!-- File Upload Section -->
                <div class="bg-purple-100 p-4 rounded-md mb-4">
                    <h3 class="text-sm font-semibold mb-2">Files:</h3>
                    <div class="flex items-center space-x-4">
                        <label for="task-files" class="text-sm font-semibold">Upload Files:</label>
                        <input type="file" id="task-files" name="task_files[]" class="border rounded flex-1 p-2" multiple>
                    </div>

                    <!-- Display the uploaded files -->
                    <div class="file-list mt-4 p-2 bg-gray-200 rounded overflow-y-auto max-h-40">
                        <!-- Placeholder to display the uploaded files -->
                    </div>
                </div>

                <!-- Button container with Flexbox -->
                <div class="flex justify-end space-x-4">
                    <!-- Close button -->
                    <button type="button" class="modal-close text-gray-500 hover:text-gray-700 bg-gray-300 rounded px-4 py-2">Close</button>

                    <!-- Submit button -->
                    <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>