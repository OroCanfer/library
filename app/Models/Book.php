<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	protected $fillable = [
		'name',
		'author',
		'publishDate',
		'categoryId',
		'userId',
		'created_at'
	];
    /**
     * Get category the book belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'id');
    }

    public function user(){
    	return $this->belongsTo(User::class, 'userId', 'id');
    }
}