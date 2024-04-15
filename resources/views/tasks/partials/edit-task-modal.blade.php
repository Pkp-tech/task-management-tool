<!-- Modal for edit/delete -->
<!-- <div id="task-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-4 rounded-md">
        <h2 id="modal-title" class="text-xl">Edit/Delete Task</h2>
        <div id="modal-content"></div>
        <button id="modal-close" class="mt-4">Close</button>
    </div>
</div> -->

<!-- Modal -->
<div id="edit-task-modal" class="task-modal fixed z-50 inset-0 bg-gray-900 bg-opacity-75 hidden">
    <div class="flex justify-center items-center h-full">
        <div class="bg-white rounded-md p-6">
            <h2 id="modal-title" class="text-lg font-bold mb-4">Edit Task</h2>

            <!-- Form inside modal -->
            <form method="post" action="{{ route('task.update') }}" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <!-- Task title input (for edit case) -->
                <input type="text" id="task-title" name="task_title" class="border rounded w-full p-2 mb-4" placeholder="Task Title">

                <!-- Task description input (optional, add if you need) -->
                <textarea id="task-description" name="task_description" class="border rounded w-full p-2 mb-4" placeholder="Task Description (Optional)"></textarea>

                <!-- Hidden input for task ID (edit or delete case) -->
                <input type="hidden" id="task-id" name="task_id" value="">

                <!-- File upload inputs -->
                <input type="file" id="task-files" name="task_files[]" class="border rounded w-full p-2 mb-4" multiple>


                <!-- Submit button -->
                <button type="submit" class="bg-blue-500 text-white rounded p-2">Save</button>
            </form>

            <!-- Close button -->
            <!-- <button id="modal-close" class="text-gray-500 hover:text-gray-700 absolute top-0 right-0 m-4">&times;</button> -->
            <button class="modal-close" class="mt-4">Close</button>
        </div>
    </div>
</div>