<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Define fillable fields if you want mass assignment
    protected $fillable = [
        'name',
        'email',
        // add other customer fields as needed
    ];
}
