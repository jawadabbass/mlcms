<?php

namespace App\Livewire\Back\Tasks;

use Livewire\Component;
use App\Models\Back\Task;
use Livewire\WithPagination;

class TasksList extends Component
{
    use WithPagination;

    public $show_filter = false;
    public $title = '';
    public $description = '';
    public $status = '';
    public $sort_by = 'title-asc';
    public $per_page = '10';

    public function render()
    {
        [$order_by_field, $asc_desc] = explode(
            '-',
            $this->sort_by
        );
        $query = Task::select('*');
        if (!empty($this->title)) {
            $query->where('title', 'like', '%' . $this->title . '%');
        }
        if (!empty($this->description)) {
            $query->where('description', 'like', '%' . $this->description . '%');
        }
        if (!empty($this->status)) {
            $query->where('status', 'like', '%' . $this->status . '%');
        }
        $taskCollection = $query->orderBy($order_by_field, $asc_desc)->paginate($this->per_page);
        return view('back.tasks.tasks_list')
        ->with('taskCollection', $taskCollection)
        ->extends('back.layouts.app', ['title' => 'Tasks']);
    }

    public function showFilters()
    {
        $this->show_filter = true;
    }
    public function hideFilters()
    {
        $this->show_filter = false;
    }
    public function setPerPage()
    {
        $this->resetPage();
    }
    public function setAscDesc()
    {
        $this->resetPage();
    }

    public function setActive($id)
    {
        $taskObj = Task::find($id);
        $taskObj->status = 'active';
        $taskObj->update();
        $this->reRender();
    }

    public function setInActive($id)
    {
        $taskObj = Task::find($id);
        $taskObj->status = 'inactive';
        $taskObj->update();
        $this->reRender();
    }

    public function delete($id)
    {
        Task::find($id)->delete();
        session()->flash('message', 'Task Deleted Successfully.');
    }

}
