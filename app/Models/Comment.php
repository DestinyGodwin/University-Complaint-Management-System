<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['complaint_id', 'user_id', 'content'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
