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

    // Define the relationship with the StatuColumn model
    public function statusColumns()
    {
        // Define a one-to-many relationship with statusColumn and enable cascade delete
        return $this->hasMany(StatusColumn::class);
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
