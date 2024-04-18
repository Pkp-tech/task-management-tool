<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function createLabel(Request $request)
    {
        // Validate the request input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Check for duplicate labels in the same task group
        $existingLabel = Label::where('name', $request->input('name'))
            ->where('task_group_id', $request->session()->get('selected_task_group_id'))
            ->first();

        if ($existingLabel) {
            return response()->json([
                'success' => false,
                'message' => 'A label with the same name already exists in this task group.'
            ], 409);
        }

        try {
            // Create a new label
            $label = new Label();
            $label->name = $request->input('name');
            $label->task_group_id = $request->session()->get('selected_task_group_id'); // set task_group_id according to your application logic
            $label->save();

            // Return a success response with the new label's ID and name
            return response()->json([
                'success' => true,
                'label_id' => $label->id,
                'label_name' => $label->name
            ]);
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json([
                'success' => false,
                'message' => 'Error creating label'
            ], 500);
        }
    }

    // method to remove a label
    public function destroy(Request $request)
    {
        // Get the label ID from the request
        $labelId = $request->input('id');

        try {
            // Find the label and delete it
            $label = Label::findOrFail($labelId);
            $label->delete();

            // Return a success response
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json(['success' => false, 'message' => 'Error removing label'], 500);
        }
    }
}
