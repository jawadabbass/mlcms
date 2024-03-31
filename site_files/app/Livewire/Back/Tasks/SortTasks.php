<?php

namespace App\Livewire\Back\Tasks;

use Livewire\Component;
use App\Models\Back\Task;

class SortTasks extends Component
{
    public $tasks, $title, $description, $taskId;
    public $isOpen = 0;

    public function render()
    {
        $this->tasks = Task::all();
        return view('back.tasks.tasks_list')->extends('back.layouts.app', ['title' => 'Tasks']);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Task::updateOrCreate(['id' => $this->taskId], [
            'title' => $this->title,
            'description' => $this->description
        ]);

        session()->flash(
            'message',
            $this->taskId ? 'Task Updated Successfully.' : 'Task Created Successfully.'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $this->taskId = $id;
        $this->title = $task->title;
        $this->description = $task->description;

        $this->openModal();
    }

    public function delete($id)
    {
        Task::find($id)->delete();
        session()->flash('message', 'Task Deleted Successfully.');
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->taskId = '';
    }
}
