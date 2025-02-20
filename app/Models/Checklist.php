<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title']; // Tambahkan 'title' agar bisa mass assignment

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
