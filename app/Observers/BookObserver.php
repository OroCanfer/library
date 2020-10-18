<?php

namespace App\Observers;

use App\Models\Book;
use App\Models\Category;

class BookObserver
{
    /**
     * Handle the book "created" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function created(Book $book)
    {
        Category::where('id', $book->categoryId)->increment('manyBooks', 1);
    }

    /**
     * Handle the book "updated" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function updated(Book $book)
    {
        //
    }

    /**
     * Listen to the User "updating" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function updating(Book $book)
    {
      if($book->isDirty('categoryId')){
        // email has changed
        $new_categoryId = $book->categoryId; 
        $old_categoryId = $book->getOriginal('categoryId');
        Category::where('id', $new_categoryId)->increment('manyBooks', 1);
        Category::where('id', $old_categoryId)->decrement('manyBooks', 1);
      }
    }

    /**
     * Handle the book "deleted" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function deleted(Book $book)
    {
        Category::where('id', $book->categoryId)->decrement('manyBooks', 1);
    }

    /**
     * Handle the book "restored" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function restored(Book $book)
    {
        //
    }

    /**
     * Handle the book "force deleted" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function forceDeleted(Book $book)
    {
        //
    }
}
