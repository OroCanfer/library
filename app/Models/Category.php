<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Get books belonging to the category.
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'categoryId', 'id');
    }
}