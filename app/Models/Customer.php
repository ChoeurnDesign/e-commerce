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

    public function scopeSearch($query, ?string $term)
    {
        $term = trim((string)$term);
        if ($term === '') return $query;

        return $query->where(function($q) use ($term) {
            if (ctype_digit($term)) {
                $q->orWhere('id', (int)$term);
            }
            $q->orWhere('name','like',"%{$term}%")
            ->orWhere('email','like',"%{$term}%");
        });
    }
}
