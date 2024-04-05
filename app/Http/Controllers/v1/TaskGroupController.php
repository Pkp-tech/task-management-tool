<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\TaskGroup;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;

class TaskGroupController extends Controller
{
    /**
     * Display the task group.
     */
    public function edit(Request $request): View
    {
        // Retrieve all task groups from the database
        $taskGroups = TaskGroup::all();

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
            // Validate the incoming request
            $request->validate([
                'task-group-name' => 'required|string|max:255|unique:task_groups',
            ]);

            // Create a new task group instance
            $taskGroup = new TaskGroup();
            $taskGroup->name = $request->input('task-group-name');
            // Set other properties as needed
            $taskGroup->save();

            // Redirect the user back to the previous page
            return Redirect::route('task-group')->with('status', 'Task group created successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions
            // dd('error-->'.$e);
            return Redirect::route('task-group')->with('error', 'Failed to create task group: ' . $e->getMessage());
        }
    }
}
