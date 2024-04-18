<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\TaskGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Models\Task;
use App\Models\Label;
use App\Models\StatusColumn;
use App\Models\TaskFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display the task.
     */
    public function index(Request $request): View
    {
        $userId = auth()->id();

        // Retrieve task groups related to the authenticated user
        $taskGroups = TaskGroup::userRelated()->get();

        // Check if the session variable is set
        $selectedTaskGroupId = $request->session()->get('selected_task_group_id');

        // Check if the session variable is not set
        if (!$selectedTaskGroupId && $taskGroups->isNotEmpty()) {
            // Set the session variable to the first task group ID
            $selectedTaskGroupId = $taskGroups->first()->id;
            $request->session()->put('selected_task_group_id', $selectedTaskGroupId);
        }

        // Retrieve user and task group-related statusColumns with associated tasks
        $statusColumns = StatusColumn::where('user_id', $userId)
            ->where('task_group_id', $selectedTaskGroupId)
            ->with(['tasks' => function ($query) {
                // Order tasks by 'updated_at' in ascending order
                $query->orderBy('updated_at', 'asc')
                    ->with('labels'); // Eager load task labels for each task;
            }])
            ->get();

        // Retrieve labels related to the selected task group
        $labels = Label::where('task_group_id', $selectedTaskGroupId)  // Filter labels by the selected task group ID
            ->get();

        return view('dashboard', [
            'user' => $request->user(),
            'taskGroups' => $taskGroups,
            'selectedTaskGroupId' => $selectedTaskGroupId, // Pass the selected task group ID to the 
            'statusColumns' => $statusColumns,
            'labels' =>  $labels,
        ]);
    }

    /**
     * Add the task.
     */
    public function add(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'task' => 'required|string|max:255',
                'status_column_id' => 'required|exists:status_columns,id',
            ]);

            // Create a new task instance
            $task = new Task();
            $task->title = $request->input('task');
            $task->task_group_id =  $request->session()->get('selected_task_group_id');
            $task->user_id = auth()->id(); // Assuming you have authentication in place
            $task->status_column_id = $request->input('status_column_id');
            // You can add other properties as needed

            // Save the task
            $task->save();

            // Get the newly created task's ID
            $taskId = $task->id;

            // Return a success response
            return response()->json(['message' => 'Task added successfully', 'taskId' => $taskId], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to add task: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update task.
     */
    public function update(Request $request)
    {
        try {
            // Retrieve the task ID from the request
            $taskId = $request->input('task_id');

            // Retrieve the task by ID
            $task = Task::findOrFail($taskId);

            // Check if the current user is the owner of the task
            if ($task->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Validate the incoming request data
            $request->validate([
                'task_title' => 'required|string|max:255',
                'task_desc' => 'sometimes|string',
                'task_files.*' => 'sometimes|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt|max:2048',
                // 'task_group_id' => 'required|exists:task_groups,id',
                // 'status_column_id' => 'required|exists:statusColumns,id',
            ]);

            // Update task attributes
            $task->title = $request->input('task_title');
            $task->description = $request->input('task_description');
            // $task->task_group_id = $request->input('task_group_id');
            // $task->status_column_id = $request->input('status_column_id');

            // Save the updated task
            $task->save();

            // Handle file uploads
            if ($request->hasFile('task_files')) {
                foreach ($request->file('task_files') as $file) {
                    // Store the file and get the path
                    $path = $file->store('task_files', 'public');

                    // Create a new TaskFile record
                    TaskFile::create([
                        'task_id' => $task->id,
                        'file_path' => $path,
                    ]);
                }
            }

            //Sync task with provided label IDs
            if ($request->has('label_ids')) {
                $labelIds = $request->input('label_ids');
                $task->labels()->sync($labelIds);
            }

            // Redirect the user back to the previous page
            return Redirect::route('dashboard')->with('status', 'Task updated successfully');
        } catch (\Exception $e) {
            // Handle any exceptions
            // dd('error-->' . $e);
            return Redirect::route('dashboard')->with('error', 'Failed to update task: ' . $e->getMessage());
        }
    }

    /**
     * Delete a task.
     */
    public function destroy(Request $request)
    {
        try {
            // Retrieve the task ID from the request
            $taskId = $request->input('task_id');

            // Retrieve the task by ID
            $task = Task::findOrFail($taskId);

            // Check if the current user is the owner of the task
            if ($task->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Delete the task
            $task->delete();

            // Redirect the user back to the previous page
            return Redirect::route('dashboard')->with('status', 'Task deleted successfully');
        } catch (\Exception $e) {
            // Handle any exceptions
            // dd('error-->' . $e);
            return Redirect::route('dashboard')->with('error', 'Failed to delete task: ' . $e->getMessage());
        }
    }

    // Method to handle AJAX request for fetching task data by ID
    public function getTaskData($id)
    {
        try {
            // Find the task by ID
            $task = Task::with('taskFiles')->with('taskLabels')->findOrFail($id);

            // get the storage URL
            $storageUrl = asset('storage/');

            // Return the task data as a JSON response
            return response()->json([
                'task_id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status_column_id' => $task->status_column_id,
                'files' => $task->taskFiles,
                'taskLabels' => $task->taskLabels,
                'storage_url' => $storageUrl,
            ], 200);
        } catch (\Exception $e) {
            // Handle any errors (e.g., task not found) and return an error response
            return response()->json([
                'message' => 'Task not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    // Method to handle the update status request
    public function updateStatus(Request $request, $taskId)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'status_column_id' => 'required|integer',
            ]);

            // Retrieve the task by ID
            $task = Task::findOrFail($taskId);

            // Check if the current user is the owner of the task
            if ($task->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Update the task's status_column_id
            $task->status_column_id = $request->input('status_column_id');
            $task->save();

            // Return a successful response
            return response()->json([
                'message' => 'Task status updated successfully',
                'task' => $task,
            ], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'error' => 'Failed to update task status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a file.
     */
    public function removeFile(Request $request)
    {
        // Retrieve the file ID and file path from the request
        $fileId = $request->input('file_id');

        // Find the file record in the database using the file ID
        $file = TaskFile::find($fileId);

        // Check if the file exists
        if ($file) {
            // Delete the file from the storage
            Storage::disk('public')->delete($file->file_path);

            // Delete the file record from the database
            $file->delete();

            // Return a success response
            return response()->json([
                'success' => true
            ]);
        } else {
            // Return an error response if the file is not found
            return response()->json([
                'success' => false,
                'error' => 'File not found'
            ]);
        }
    }
}
