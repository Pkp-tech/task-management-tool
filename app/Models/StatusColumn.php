<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusColumn extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'status_columns';


    // Specify the fillable attributes
    protected $fillable = [
        'name',
        'user_id',
        'task_group_id',
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

    // Define the relationship with the Task model
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
