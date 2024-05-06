<?php

namespace App\Livewire\Priorities;

use Livewire\Component;
use App\Models\Priority;

class PriorityComponent extends Component
{
    public $priorityId;
    public $name;
    public string $sortColumn = 'created_at';
    public string $sortDirection = 'desc';
    public $search = '';
    public $perPage = 10;
    public $showModal = false;
    public $deleteModal = false;
    public $error_string = '';

    protected $rules = [
        'name' => 'required|min:3',
    ];

    public function render()
    {
        $priorities = Priority::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.priorities.priority-component', ['priorities' => $priorities]);
    }

    public function openModal()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    public function createPriority()
    {
        $this->validate();
        Priority::create(['name' => $this->name]);
        $this->showModal = false;
        $this->resetInput();
    }

    public function editPriority($id)
    {
        $priority = Priority::findOrFail($id);
        $this->priorityId = $id;
        $this->name = $priority->name;
        $this->showModal = true;
    }

    public function updatePriority()
    {
        $this->validate();
        $priority = Priority::findOrFail($this->priorityId);
        $priority->update(['name' => $this->name]);
        $this->showModal = false;
        $this->resetInput();
    }

    public function showDeleteModal($id)
    {
        $this->priorityId = $id;
        $this->name = Priority::findOrFail($id)->name;
        $this->deleteModal = true;
    }

    public function deletePriority()
    {
        Priority::destroy($this->priorityId);
        $this->deleteModal = false;
    }

    private function resetInput()
    {
        $this->priorityId = null;
        $this->name = '';
    }
}
