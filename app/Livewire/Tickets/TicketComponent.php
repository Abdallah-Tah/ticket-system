<?php

namespace App\Livewire\Tickets;

use App\Models\Plan;
use App\Models\Status;
use Livewire\Component;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Department;
use App\Models\Ticket;

class TicketComponent extends Component
{
    public $user_id;
    public $department_id;
    public $plan_id;
    public $category_id;
    public $status_id;
    public $priority_id;
    public $claim_number;
    public $title;
    public $requestor_name;
    public $problem_statement;
    public $target_date;
    public $ticket_id;
    public $categories = [];
    public $departments = [];
    public $plans = [];
    public $statuses = [];
    public $priorities = [];
    public string $sortColumn = 'created_at';
    public string $sortDirection = 'desc';
    public $sortBy;
    public $sortAsc = true;
    public $showModal = false;
    public $deleteModal = false;
    public $error_string = '';

    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->categories = Category::all();
        $this->departments = Department::all();
        $this->plans = Plan::all();
        $this->statuses = Status::all();
        $this->priorities = Priority::all();
    }

    public function sortBy($field)
    {
        if ($this->sortColumn === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortColumn = $field;
    }

    public function resetFilters()
    {
        $this->reset(['department_id', 'plan_id', 'category_id', 'status_id', 'priority_id', 'claim_number', 'title', 'requestor_name', 'problem_statement', 'target_date']);
    }

    public function openModal()
    {
        $this->error_string = '';
        $this->resetFilters();
        $this->showModal = true;
    }

    public function createTicket()
    {
        // $this->validate([
        //     'department_id' => 'required',
        //     'plan_id' => 'required',
        //     'category_id' => 'required',
        //     'status_id' => 'required',
        //     'priority_id' => 'required',
        //     'claim_number' => 'required',
        //     'title' => 'required',
        //     'requestor_name' => 'required',
        //     'problem_statement' => 'required',
        //     'target_date' => 'required',
        // ]);

        Ticket::create([
            'department_id' => $this->department_id,
            'plan_id' => $this->plan_id,
            'category_id' => $this->category_id,
            'status_id' => $this->status_id,
            'priority_id' => $this->priority_id,
            'claim_number' => $this->claim_number,
            'title' => $this->title,
            'requestor_name' => $this->requestor_name,
            'problem_statement' => $this->problem_statement,
            'target_date' => $this->target_date,
            'user_id' => $this->user_id,
        ]);

        $this->showModal = false;
    }

    public function showEditModal($id)
    {
        $this->error_string = '';
        $this->resetFilters();
        $this->showModal = true;
        $this->ticket_id = $id;
        $ticket = Ticket::find($id);
        $this->department_id = $ticket->department_id;
        $this->plan_id = $ticket->plan_id;
        $this->category_id = $ticket->category_id;
        $this->status_id = $ticket->status_id;
        $this->priority_id = $ticket->priority_id;
        $this->claim_number = $ticket->claim_number;
        $this->title = $ticket->title;
        $this->requestor_name = $ticket->requestor_name;
        $this->problem_statement = $ticket->problem_statement;
        $this->target_date = $ticket->target_date;
    }

    public function updateTicket()
    {
        // $this->validate([
        //     'department_id' => 'required',
        //     'plan_id' => 'required',
        //     'category_id' => 'required',
        //     'status_id' => 'required',
        //     'priority_id' => 'required',
        //     'claim_number' => 'required',
        //     'title' => 'required',
        //     'requestor_name' => 'required',
        //     'problem_statement' => 'required',
        //     'target_date' => 'required',
        // ]);

        $ticket = Ticket::find($this->ticket_id);
        $ticket->update([
            'department_id' => $this->department_id,
            'plan_id' => $this->plan_id,
            'category_id' => $this->category_id,
            'status_id' => $this->status_id,
            'priority_id' => $this->priority_id,
            'claim_number' => $this->claim_number,
            'title' => $this->title,
            'requestor_name' => $this->requestor_name,
            'problem_statement' => $this->problem_statement,
            'target_date' => $this->target_date,
        ]);

        $this->showModal = false;
    }

    public function showDeleteModal($id)
    {
        $this->ticket_id = $id;
        $this->deleteModal = true;
    }

    public function deleteTicket()
    {
        Ticket::find($this->ticket_id)->delete();
        $this->deleteModal = false;
    }

    public function viewTicket($id)
    {
        return redirect()->route('tickets.show', $id);
    }

    public function render()
    {
        $tickets = Ticket::query()
            ->when($this->department_id, function ($query) {
                return $query->where('department_id', $this->department_id);
            })
            ->when($this->plan_id, function ($query) {
                return $query->where('plan_id', $this->plan_id);
            })
            ->when($this->category_id, function ($query) {
                return $query->where('category_id', $this->category_id);
            })
            ->when($this->status_id, function ($query) {
                return $query->where('status_id', $this->status_id);
            })
            ->when($this->priority_id, function ($query) {
                return $query->where('priority_id', $this->priority_id);
            })
            ->when($this->claim_number, function ($query) {
                return $query->where('claim_number', 'like', '%' . $this->claim_number . '%');
            })
            ->when($this->title, function ($query) {
                return $query->where('title', 'like', '%' . $this->title . '%');
            })
            ->when($this->requestor_name, function ($query) {
                return $query->where('requestor_name', 'like', '%' . $this->requestor_name . '%');
            })
            ->when($this->problem_statement, function ($query) {
                return $query->where('problem_statement', 'like', '%' . $this->problem_statement . '%');
            })
            ->when($this->target_date, function ($query) {
                return $query->where('target_date', 'like', '%' . $this->target_date . '%');
            })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate(10);

        return view('livewire.tickets.ticket-component')->with('tickets', $tickets);
    }
}
