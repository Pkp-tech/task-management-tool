<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\StatusColumn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class StatusColumnController extends Controller
{
    /**
     * Add a new status column.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        try {
            $request->validate([
                'statusColumn' => 'required|string|max:255',
            ]);

            // Retrieve data from the request
            $statusColumnName = $request->input('statusColumn');
            $taskGroupId = $request->session()->get('selected_task_group_id');

            // Create a new status column instance
            $statusColumn = new StatusColumn();
            $statusColumn->name = $statusColumnName;
            $statusColumn->user_id = auth()->id();
            $statusColumn->task_group_id = $taskGroupId; // Assuming task_group_id is stored in session

            // Save the status column
            $statusColumn->save();

            // Get the newly created statusColumn's ID
            $statusColumnId = $statusColumn->id;

            return response()->json(['message' => 'Status Column added successfully', 'statusColumnId' => $statusColumnId], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to add status column: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update a status column based on the provided status column ID from the request
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            // Retrieve the status column ID from the request
            $statusColumnId = $request->input('status_column_id');

            // Retrieve the status column by ID
            $statusColumn = StatusColumn::findOrFail($statusColumnId);

            // Check if the current user is the owner of the status column
            if ($statusColumn->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Validate the incoming request data
            $request->validate([
                'status_column_name' => 'required|string|max:255',
            ]);

            // Update status column attributes
            $statusColumn->name = $request->input('status_column_name');

            // Save the updated status column
            $statusColumn->save();

            $newStatusColumn = $statusColumn->name;

            return response()->json(['message' => 'Status Column updated successfully', 'newStatusColumn' => $newStatusColumn], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to update status column: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete a status column based on the provided status column ID from the request
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            // Retrieve the status column ID from the request
            $statusColumnId = $request->input('status_column_id');

            // Retrieve the status column by ID
            $statusColumn = StatusColumn::findOrFail($statusColumnId);

            // Check if the current user is the owner of the status column
            if ($statusColumn->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Delete the status column
            $statusColumn->delete();

         // Redirect the user back to the previous page
            return Redirect::route('dashboard')->with('status', 'Status Column deleted successfully');
        } catch (\Exception $e) {
            // Handle any exceptions
            // dd('error-->' . $e);
            return Redirect::route('dashboard')->with('error', 'Failed to delete status column: ' . $e->getMessage());
        }
    }
}
