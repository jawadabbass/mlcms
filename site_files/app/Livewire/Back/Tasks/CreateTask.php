<?php

namespace App\Livewire\Back\Tasks;

use Livewire\Component;
use App\Models\Back\Task;

class CreateTask extends Component
{
    public $title;
    public $description;
    public $status = 'active';

    public function render()
    {
        return view('back.tasks.create')->extends('back.layouts.app', ['title' => 'Create Task']);
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        $taskObj = new Task();
        $taskObj->title = $this->title;
        $taskObj->description = $this->description;
        $taskObj->status = $this->status;
        $taskObj->save();

        session()->flash('message', 'Task Created Successfully.');
        return $this->redirectRoute('tasks.list', parameters: [], absolute: true, navigate: true);
    }
}
