<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Enums\BookStatus;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // N+1問題対策: with('genre') を付けないと、ビューで $book->genre を
        // 参照するたびに genres テーブルへのSELECTが発行される（本の数だけ）。
        // with を付けると、使われている genre_id をまとめて WHERE IN で1回取得し、
        // 各 book に紐付けてくれる（Eager Loading）。
        $books = Book::with('genre')->orderBy('created_at', 'desc')->get();

        return view('books.index', [
            'books'  => $books,
            'statuses' => BookStatus::cases(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create', [
            'genres'   => Genre::orderBy('id')->get(),
            'statuses' => BookStatus::cases(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        Book::create($request->validated());

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('genre');

        return view('books.show',[
            'book'   => $book,
            'statuses' => BookStatus::cases()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.edit', [
            'book'     => $book,
            'genres'   => Genre::orderBy('id')->get(),
            'statuses' => BookStatus::cases(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()->route('books.show', $book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index');
    }

    public function updateStatus(Request $request, Book $book)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::enum(BookStatus::class)],
        ]);

        $book->update($validated);

        return response()->json(['status' => $book->status->value]);
    }
}
