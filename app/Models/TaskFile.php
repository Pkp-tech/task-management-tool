<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id', // Associated task's ID
        'file_path', // File path
        'file_name',
    ];

    /**
     * Get the task associated with the file.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
