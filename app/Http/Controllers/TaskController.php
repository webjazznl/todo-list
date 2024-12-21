<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    // Validatieregels als property -> DRY!
    protected $validationRules = [
        'title' => 'required|max:255',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'description' => 'nullable|max:1024',
    ];

    // Validatieboodschap als property -> DRY!
    protected $validationMessages = [
        'end_date.after_or_equal' => 'The end date must be a date after or equal to the start date.',
    ];

    // Lijst van taken tonen
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    // Formulier voor nieuwe taak
    public function create()
    {
        return view('tasks.create');
    }

    // Nieuwe taak opslaan
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules, $this->validationMessages); $request->validate($this->validationRules, $this->validationMessages);
        Task::create($validatedData);

        return redirect()->route('tasks.index')->with('success', 'Nieuwe taak aangemaakt');
    }

    // Eén taak bekijken
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    // Formulier voor taak bewerken
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Bijgewerkte taak opslaan
    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate($this->validationRules, $this->validationMessages); $request->validate($this->validationRules, $this->validationMessages);
        $task->update($validatedData);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    // Taak verwijderen
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Taak verwijderd');
    }

    //Taak markeren als gereed
    public function completed(Task $task)
    {
        $task->completed = true;
        $task->save();
        return redirect()->route('tasks.index')->with('success', 'Hoera! Deze taak is gereed: ' . $task->title  );
    }
}
