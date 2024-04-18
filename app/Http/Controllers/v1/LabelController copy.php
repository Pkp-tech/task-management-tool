<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;

class LabelController extends Controller
{
    /**
     * Add a new label.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        try {
            $request->validate([
                'label' => 'required|string|max:255',
            ]);

            // Retrieve data from the request
            $labelName = $request->input('label');
            $taskGroupId = $request->session()->get('selected_task_group_id');

            // Create a new label instance
            $label = new Label();
            $label->name = $labelName;
            $label->user_id = auth()->id();
            $label->task_group_id = $taskGroupId; // Assuming task_group_id is stored in session

            // Save the label
            $label->save();

            // Get the newly created label's ID
            $statusColumnId = $label->id;

            return response()->json(['message' => 'Label added successfully', 'statusColumnId' => $statusColumnId], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to add label: ' . $e->getMessage()], 500);
        }
    }

    // Update a label based on the provided label ID from the request
    public function update(Request $request)
    {
        try {
            // Retrieve the label ID from the request
            $statusColumnId = $request->input('status_column_id');

            // Retrieve the label by ID
            $label = Label::findOrFail($statusColumnId);

            // Check if the current user is the owner of the label
            if ($label->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Validate the incoming request data
            $request->validate([
                'label_name' => 'required|string|max:255',
            ]);

            // Update label attributes
            $label->name = $request->input('label_name');

            // Save the updated label
            $label->save();

            $newLabel = $label->name;

            return response()->json(['message' => 'Label updated successfully', 'newLabel' => $newLabel], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to update label: ' . $e->getMessage()], 500);
        }
    }

    // Delete a label based on the provided label ID from the request
    public function destroy(Request $request)
    {
        try {
            // Retrieve the label ID from the request
            $statusColumnId = $request->input('status_column_id');

            // Retrieve the label by ID
            $label = Label::findOrFail($statusColumnId);

            // Check if the current user is the owner of the label
            if ($label->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Delete the label
            $label->delete();

         // Redirect the user back to the previous page
            return Redirect::route('dashboard')->with('status', 'Label deleted successfully');
        } catch (\Exception $e) {
            // Handle any exceptions
            // dd('error-->' . $e);
            return Redirect::route('dashboard')->with('error', 'Failed to delete label: ' . $e->getMessage());
        }
    }
}
