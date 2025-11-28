<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\StoreTodoRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TodoExport;

class TodoController extends Controller
{
    public function store(StoreTodoRequest $request)
    {
        $todo = Todo::create($request->validated());

        return response()->json([
            'message' => 'Todo created successfully',
            'data' => $todo
        ], 201);
    }
     public function export(Request $request)
    {
        $query = Todo::query();

        // 1. Partial Match Title
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // 2. Assignee (comma separated)
        if ($request->has('assignee')) {
            $assignees = explode(',', $request->assignee);
            $query->whereIn('assignee', $assignees);
        }

        // 3. Status (comma separated)
        if ($request->has('status')) {
            $statuses = explode(',', $request->status);
            $query->whereIn('status', $statuses);
        }

        // 4. Priority (comma separated)
        if ($request->has('priority')) {
            $priorities = explode(',', $request->priority);
            $query->whereIn('priority', $priorities);
        }

        // 5. Due Date Range (Format: start=YYYY-MM-DD&end=YYYY-MM-DD)
        // Note: The user sends ?due_date=start=2023-01-01&end=2023-01-02
        if ($request->has('due_date')) {
            // We parse the string manually
            parse_str($request->due_date, $dates); 
            
            if (isset($dates['start']) && isset($dates['end'])) {
                $query->whereBetween('due_date', [$dates['start'], $dates['end']]);
            }
        }

        // 6. Time Tracked Range (Format: min=X&max=Y)
        if ($request->has('time_tracked')) {
            parse_str($request->time_tracked, $times);
            
            if (isset($times['min']) && isset($times['max'])) {
                $query->whereBetween('time_tracked', [$times['min'], $times['max']]);
            }
        }

        $todos = $query->get();

        return Excel::download(new TodoExport($todos), 'todos_report.xlsx');
    }

}
