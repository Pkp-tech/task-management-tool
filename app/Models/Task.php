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
        'label_id',
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

    // Define the relationship with the Label model
    public function label()
    {
        return $this->belongsTo(Label::class);
    }
}
