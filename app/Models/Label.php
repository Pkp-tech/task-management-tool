<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'task_group_id',
    ];

    public function taskGroup()
    {
        return $this->belongsTo(TaskGroup::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_labels');
    }
}
