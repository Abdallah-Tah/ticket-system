<?php

namespace App\Livewire\Departments;

use Livewire\Component;
use App\Models\Department;

class DepartmentComponent extends Component
{
    public $departmentId;
    public $name;
    public string $sortColumn = 'created_at';
    public string $sortDirection = 'desc';
    public $sortBy;
    public $sortAsc = true;
    public $showModal = false;
    public $deleteModal = false;
    public $error_string = '';
    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'name' => 'required|min:3',
    ];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function createDepartment()
    {
        $this->validate();
        Department::create([
            'name' => $this->name,
        ]);
        $this->showModal = false;
        $this->reset();
    }

    public function editDepartement($id)
    {
        $department = Department::findOrFail($id);
        $this->departmentId = $id;
        $this->name = $department->name;
        $this->showModal = true;
    }

    public function updateDepartment()
    {
        $this->validate();
        $department = Department::findOrFail($this->departmentId);
        $department->update([
            'name' => $this->name,
        ]);
        $this->showModal = false;
        $this->reset();
    }

    public function showDeleteModal($id)
    {
        $this->reset();

        $this->departmentId = $id;
        $this->name = Department::findOrFail($id)->name;
        $this->deleteModal = true;
    }

    public function deleteDepartment()
    {
        Department::destroy($this->departmentId);
        $this->deleteModal = false;
    }

    public function render()
    {
        $departments = Department::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);
        return view(
            'livewire.departments.department-component',
            [
                'departments' => $departments
            ]
        );
    }
}
