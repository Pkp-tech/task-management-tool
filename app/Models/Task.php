<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['task_group_id', 'title', 'description', 'assigned_to', 'status', 'labels', 'file_path'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the task group that owns this task.
     */
    public function group()
    {
        return $this->belongsTo(TaskGroup::class, 'task_group_id');
    }

    /**
     * Get the user assigned to this task.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    protected $guarded = [];

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
