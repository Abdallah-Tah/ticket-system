<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'plan_id',
        'category_id',
        'status_id',
        'priority_id',
        'claim_number',
        'title',
        'requestor_name',
        'problem_statement',
        'target_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    // public function attachments()
    // {
    //     return $this->hasMany(TicketAttachment::class);
    // }
}
