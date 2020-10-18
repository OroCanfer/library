<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $book_query = Book::query();

        $users = User::all();
        $categories = Category::all();

        if($request->category){
            $book_query->whereHas('category', function($q) use ($request){
                $q->where('name', $request->category);
            });
        }

        if($request->search){
            $book_query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if($request->sortByAuthor && in_array($request->sortByAuthor, ['asc', 'desc'])){
            $book_query->orderBy('author', $request->sortByAuthor);
        }

        if($request->sortByCategory && in_array($request->sortByCategory, ['asc', 'desc'])){
            $book_query->join('categories', 'books.categoryId', 'categories.id')->orderBy('categories.name', $request->sortByCategory);
        }

        $books = $book_query->orderBy('books.id', 'DESC')->simplePaginate(5);

        return view('books.index', compact('books', 'users', 'categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'author' => 'required',
            'publishDate' => 'required'
        ]);

        if($request->input('categoryId') == 0) $request->merge(['categoryId' => null]);
        $request->request->add(['userId' => null]);

        Book::create($request->all());

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $categories = Category::all();

        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name' => 'required',
            'author' => 'required',
            'publishDate' => 'required'
        ]);
        $book->update($request->all());

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function availabilityUpdate(Request $request, Book $book)
    {
        $request->validate([
            'userId' => 'required'
        ]);

        if($request->input('userId') == 0) $request->merge(['userId' => null]);

        $book->update($request->all());

        return redirect()->route('books.index')
            ->with('success', 'Availability updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully');
    }
}
