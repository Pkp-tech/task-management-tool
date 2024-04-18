<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Specify the fillable attributes
    protected $fillable = [
        'title',
        'user_id',
        'task_group_id',
        'status_column_id',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the TaskGroup model
    public function taskGroup()
    {
        return $this->belongsTo(TaskGroup::class);
    }

    // Define the relationship with the status column model
    public function statusColumns()
    {
        return $this->belongsTo(StatusColumn::class);
    }

    // Define the relationship with TaskFile
    public function taskFiles()
    {
        return $this->hasMany(TaskFile::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'task_labels');
    }

    // Define the relationship with TaskFile
    public function taskLabels()
    {
        return $this->hasMany(TaskLabel::class);
    }
}
