<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\TaskGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display the task.
     */
    public function index(Request $request): View
    {
        // Retrieve task groups related to the authenticated user
        $taskGroups = TaskGroup::userRelated()->get();

        return view('dashboard', [
            'user' => $request->user(),
            'taskGroups' => $taskGroups,
        ]);
    }
}
