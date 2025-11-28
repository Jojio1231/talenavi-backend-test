<?php

namespace App\Exports;

use App\Models\Todo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TodoExport implements FromCollection, WithHeadings, WithEvents
{
    protected $todos;

    // We pass the filtered data into this class
    public function __construct($todos)
    {
        $this->todos = $todos;
    }

    public function collection()
    {
        // Select only the columns asked in the PDF
        return $this->todos->map(function ($todo) {
            return [
                'title' => $todo->title,
                'assignee' => $todo->assignee,
                'due_date' => $todo->due_date,
                'time_tracked' => $todo->time_tracked,
                'status' => $todo->status,
                'priority' => $todo->priority,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Title', 'Assignee', 'Due Date', 'Time Tracked', 'Status', 'Priority'
        ];
    }

    // This adds the "Total" row at the bottom
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $totalTodos = $this->todos->count();
                $totalTime = $this->todos->sum('time_tracked');

                // Append a row at the end
                $event->sheet->append([
                    'Total Todos: ' . $totalTodos,
                    '', // Empty col
                    '', // Empty col
                    'Total Time: ' . $totalTime,
                    '', // Empty col
                    ''  // Empty col
                ]);
            },
        ];
    }
}

