<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\TaskGroup;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TaskGroupController extends Controller
{
    /**
     * Display the task group.
     */
    public function edit(Request $request): View
    {
        // Retrieve task groups related to the authenticated user
        $taskGroups = TaskGroup::userRelated()->get();

        return view('tasks.task-group', [
            'user' => $request->user(),
            'taskGroups' => $taskGroups,
        ]);
    }

    /**
     * Create a new task group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request): RedirectResponse
    {
        try {
            
            $request->validateWithBag('taskGroupValidation', [
                'task-group-name' => 'required|string|max:255|unique:task_groups,name,NULL,id,user_id,' . auth()->id(),
            ]);

            // Create a new task group instance
            $taskGroup = new TaskGroup();
            $taskGroup->name = $request->input('task-group-name');
            $taskGroup->user_id = Auth::id();
            // Set other properties as needed
            $taskGroup->save();

            // Redirect the user back to the previous page
            return Redirect::route('task-group')->with('task-group-status', 'Task group created successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions
            return Redirect::route('task-group')->with('task-group-error', 'Failed to create task group: ' . $e->getMessage());
        }
    }

    /**
     * Update task group.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $taskGroup = TaskGroup::findOrFail($id);

            // Validate the incoming request
            $request->validateWithBag('taskGroupValidation', [
                'task-group-name' => 'required|string|max:255|unique:task_groups,name,' . $id . ',id,user_id,' . Auth::id(),
            ]);

            $taskGroup->update([
                'name' => $request->input('task-group-name'),
            ]);

            return Redirect::route('task-group')->with('task-group-status', 'Task group updated successfully.');
        } catch (\Exception $e) {
            return Redirect::back()->with('task-group-error', 'Failed to update task group.')->withErrors([$e->getMessage()]);
        }
    }

    /**
     * Delete a task group.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $taskGroup = TaskGroup::findOrFail($id);

            // Check if the authenticated user owns the task group
            if ($taskGroup->user_id != Auth::id()) {
                throw new \Exception("Unauthorized to delete this task group.");
            }

            $taskGroup->delete();

            // Check the session for the task group ID
            if (session()->has('selected_task_group_id') && session('selected_task_group_id') == $id) {
                // Clear the session value if it matches the deleted task group ID
                session()->forget('selected_task_group_id');
            }

            return Redirect::route('task-group')->with('task-group-status', 'Task group deleted successfully.');
        } catch (\Exception $e) {
            return Redirect::back()->with('task-group-delete-error', 'Failed to delete task group.')->withErrors([$e->getMessage()]);
        }
    }

    /**
     * Update the session variable to store the selected task group ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTaskGroupSession(Request $request)
    {
        try {
            // Retrieve the task group ID from the request
            $taskGroupId = $request->input('task_group_id');

            // Update the session variable with the selected task group ID
            session()->put('selected_task_group_id', $taskGroupId);

            // Return a success response
            return response()->json(['message' => 'Session variable updated successfully']);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => 'Failed to update session variable: ' . $e->getMessage()], 500);
        }
    }
}
