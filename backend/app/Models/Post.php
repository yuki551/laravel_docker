<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user', 'team', 'contents_am', 'contents_pm', 'client_am', 'client_pm', 'summary_am', 'summary_pm', 'created_user_id', 'status', 'comment', 'role_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'users', 'role_id');
    }
}
