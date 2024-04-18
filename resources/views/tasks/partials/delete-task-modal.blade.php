<!-- Modal -->
<div id="delete-task-modal" class="task-modal fixed z-50 inset-0 bg-gray-900 bg-opacity-75 hidden">
    <div class="flex justify-center items-center h-full">
        <div class="bg-white rounded-md p-6">
            <h2 id="modal-title" class="text-lg font-bold mb-4">Delete Task</h2>

            <p>Are you sure you want to delete this task?</p>

            <!-- Form inside modal -->
            <form method="post" action="{{ route('task.destroy') }}" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('delete')

                <!-- Task title input (for edit case) -->
                <input type="text" id="task-title" name="task_title" class="border rounded w-full p-2 mb-4" disabled>

                <!-- Hidden input for task ID (edit or delete case) -->
                <input type="hidden" id="task-id" name="task_id" value="">

                <!-- Button container with Flexbox -->
                <div class="flex justify-end">
                    <!-- Close button -->
                    <button type="button" class="modal-close text-gray-500 hover:text-gray-700 bg-gray-300 rounded p-2 mr-2">Close</button>

                    <!-- Delete button -->
                    <button type="submit" class="bg-red-700 text-white rounded p-2">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>