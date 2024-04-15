<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskGroup extends Model
{
    use HasFactory;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<string>
    //  */
    // protected $fillable = ['name'];

    // /**
    //  * Get the tasks associated with this task group.
    //  */
    // public function tasks()
    // {
    //     return $this->hasMany(Task::class);
    // }
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Label model
    public function labels()
    {
        // Define a one-to-many relationship with labels and enable cascade delete
        return $this->hasMany(Label::class);
    }


    /**
     * Scope a query to only include task groups related to the authenticated user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserRelated($query)
    {
        return $query->where('user_id', Auth::id());
    }
}
