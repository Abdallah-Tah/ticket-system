<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TicketComment;
use Livewire\WithFileUploads;

class ViewTicketComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $ticketId, $commentId;
    public $name, $comment;
    public $search;
    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $sortAsc = true;
    public $perPage = 10;
    public $page = 1;
    public $ticket;
    public $deleteModal = false;
    public $showModal = false;
    public $sortColumn = 'id';
    public $error_string = '';
    public $editingCommentId = null;

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->ticketId = $ticket->id;

    }

    public function sortBy($field)
    {
        if ($this->sortColumn == $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        if ($this->sortAsc) {
            $this->sortDirection = 'asc';
        } else {
            $this->sortDirection = 'desc';
        }

        $this->sortColumn = $field;
    }

    public function editComment($commentId)
    {
        $this->editingCommentId = $commentId;
        $comment = Comment::find($commentId);
        $this->comment = $comment->message; // Load existing comment into textarea
    }

    public function updateComment()
    {

        $comment = Comment::find($this->editingCommentId);
        if ($comment) {
            $comment->message = $this->comment; // Save the updated text from textarea
            $comment->save();
            session()->flash('message', 'Comment updated successfully');
        } else {
            session()->flash('error', 'Comment not found');
        }

        $this->reset(['editingCommentId', 'comment']);
    }


    public function createComment()
    {
        // dd($this->comment);
        // $this->validate(['comment' => 'required']);
        Comment::create([
            'ticket_id' => $this->ticketId,
            'user_id' => auth()->id(),
            'message' => $this->comment
        ]);

        $this->comment = ''; // Reset comment after storing
    }

    // public function showEditComment($id)
    // {
    //     $this->commentId = $id;
    //     $this->showModal = true;
    //     $this->comment = Comment::find($id)->message;
    // }

    // public function storeTicketComment()
    // {
    //     $this->validate([
    //         'comment' => 'required'
    //     ]);

    //     Comment::create([
    //         'ticket_id' => $this->ticket->id,
    //         'user_id' => auth()->user()->id,
    //         'message' => $this->comment
    //     ]);

    //     $this->comment = '';
    //     session()->flash('message', 'Comment added successfully');
    // }

    // public function updateComment()
    // {
    //     $this->validate([
    //         'comment' => 'required'
    //     ]);

    //     $comment = Comment::find($this->commentId);
    //     $comment->update([
    //         'message' => $this->comment
    //     ]);

    //     $this->showModal = false;
    //     $this->comment = '';
    //     session()->flash('message', 'Comment updated successfully');
    // }

    public function showDeleteComment($id)
    {
        $this->commentId = $id;
        $this->deleteModal = true;
    }

    public function deleteComment()
    {
        $comment = Comment::find($this->commentId);
        $comment->delete();
        $this->deleteModal = false;
        session()->flash('message', 'Comment deleted successfully');
    }


    public function render()
    {
        $ticketComments = Comment::where('ticket_id', $this->ticketId)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->perPage);


        return view(
            'livewire.tickets.view-ticket-component'
            ,
            [
                'ticketComments' => $ticketComments
            ]
        );
    }
}
