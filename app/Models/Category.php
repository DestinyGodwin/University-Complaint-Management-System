<?php

namespace App\Models;

use App\Models\Complaint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
