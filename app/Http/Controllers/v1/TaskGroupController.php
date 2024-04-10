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
            // dd('here');
            // Validate the incoming request
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);

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
            return Redirect::route('task-group')->with('status', 'Task group created successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions
            // dd('error-->' . $e);
            return Redirect::route('task-group')->with('error', 'Failed to create task group: ' . $e->getMessage());
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

            return Redirect::route('task-group')->with('success', 'Task group updated successfully.');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Failed to update task group.')->withErrors([$e->getMessage()]);
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

            return Redirect::route('task-group')->with('status', 'Task group deleted successfully.');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Failed to delete task group.')->withErrors([$e->getMessage()]);
        }
    }
}
