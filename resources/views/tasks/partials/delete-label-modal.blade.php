<!-- Modal -->
<div id="delete-label-modal" class="task-modal fixed z-50 inset-0 bg-gray-900 bg-opacity-75 hidden">
    <div class="flex justify-center items-center h-full">
        <div class="bg-white rounded-md p-6">
            <h2 id="modal-title" class="text-lg font-bold mb-4">Delete Label</h2>

            <p>Are you sure you want to delete this label?</p>
           
            <!-- Form inside modal -->
            <form method="post" action="{{ route('label.destroy') }}" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('delete')

                <!-- Task title input (for edit case) -->
                <input type="text" id="label-title" name="label_title" class="border rounded w-full p-2 mb-4" disabled>
               
                <!-- Hidden input for label ID (edit or delete case) -->
                <input type="hidden" id="label-id" name="label_id" value="">

                <!-- Submit button -->
                <button type="submit" class="bg-red-700 text-white rounded p-2">Delete</button>
            </form>

            <!-- Close button -->
            <!-- <button id="modal-close" class="text-gray-500 hover:text-gray-700 absolute top-0 right-0 m-4">&times;</button> -->
            <button class="modal-close" class="mt-4">Close</button>
        </div>
    </div>
</div>