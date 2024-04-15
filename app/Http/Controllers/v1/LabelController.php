<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            $labelId = $label->id;

            return response()->json(['message' => 'Label added successfully', 'labelId' => $labelId], 200);
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
            $labelId = $request->input('label_id');

            // Retrieve the label by ID
            $label = Label::findOrFail($labelId);

            // Check if the current user is the owner of the label
            if ($label->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Validate the incoming request data
            $request->validate([
                'name' => 'required|string|max:255',
                'task_group_id' => 'required|exists:task_groups,id',
            ]);

            // Update label attributes
            $label->name = $request->input('name');
            $label->task_group_id = $request->input('task_group_id');

            // Save the updated label
            $label->save();

            // Return a JSON response indicating success
            return response()->json(['message' => 'Label updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    // Delete a label based on the provided label ID from the request
    public function delete(Request $request)
    {
        try {
            // Retrieve the label ID from the request
            $labelId = $request->input('label_id');

            // Retrieve the label by ID
            $label = Label::findOrFail($labelId);

            // Check if the current user is the owner of the label
            if ($label->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Delete the label
            $label->delete();

            // Return a JSON response indicating success
            return response()->json(['message' => 'Label deleted successfully'], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
