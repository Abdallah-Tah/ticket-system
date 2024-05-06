<?php

namespace App\Livewire\Statuses;

use Livewire\Component;
use App\Models\Status;

class StatusComponent extends Component
{
    public $statusId;
    public $name;
    public string $sortColumn = 'created_at';
    public string $sortDirection = 'desc';
    public $sortBy;
    public $sortAsc = true;
    public $search = '';
    public $perPage = 10;
    public $showModal = false;
    public $deleteModal = false;
    public $error_string = '';

    protected $rules = [
        'name' => 'required|min:3',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortByColumn($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $statuses = Status::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.statuses.status-component', ['statuses' => $statuses]);
    }

    public function openModal()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    public function createStatus()
    {
        $this->validate();
        Status::create(['name' => $this->name]);
        $this->showModal = false;
        $this->resetInput();
    }

    public function editStatus($id)
    {
        $status = Status::findOrFail($id);
        $this->statusId = $id;
        $this->name = $status->name;
        $this->showModal = true;
    }

    public function updateStatus()
    {
        $this->validate();
        $status = Status::findOrFail($this->statusId);
        $status->update(['name' => $this->name]);
        $this->showModal = false;
        $this->resetInput();
    }

    public function showDeleteModal($id)
    {
        $this->statusId = $id;
        $this->name = Status::findOrFail($id)->name;
        $this->deleteModal = true;
    }

    public function deleteStatus()
    {
        Status::destroy($this->statusId);
        $this->deleteModal = false;
    }

    private function resetInput()
    {
        $this->statusId = null;
        $this->name = '';
    }
}
