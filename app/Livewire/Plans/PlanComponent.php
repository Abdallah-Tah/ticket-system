<?php

namespace App\Livewire\Plans;

use Livewire\Component;
use App\Models\Plan;

class PlanComponent extends Component
{
    public $planId;
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

    public function updating($name)
    {
        // $this->resetPage();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
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
        $plans = Plan::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.plans.plan-component', ['plans' => $plans]);
    }

    public function openModal()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    public function createPlan()
    {
        $this->validate();
        Plan::create(['name' => $this->name]);
        $this->showModal = false;
        $this->resetInput();
    }

    public function editPlan($id)
    {
        $plan = Plan::findOrFail($id);
        $this->planId = $id;
        $this->name = $plan->name;
        $this->showModal = true;
    }

    public function updatePlan()
    {
        $this->validate();
        $plan = Plan::findOrFail($this->planId);
        $plan->update(['name' => $this->name]);
        $this->showModal = false;
        $this->resetInput();
    }

    public function showDeleteModal($id)
    {
        $this->planId = $id;
        $this->name = Plan::findOrFail($id)->name;
        $this->deleteModal = true;
    }

    public function deletePlan()
    {
        Plan::destroy($this->planId);
        $this->deleteModal = false;
    }

    private function resetInput()
    {
        $this->planId = null;
        $this->name = '';
    }
}
