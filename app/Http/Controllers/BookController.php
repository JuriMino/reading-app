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
    public function index(Request $request)
    {
        $query = Book::with('genre');

        // キーワード（タイトル・著者・出版社のOR部分一致）
        if($request->filled('keyword')){
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword){
                $q->where('title','like', "%{$keyword}%")
                ->orWhere('author','like', "%{$keyword}%")
                ->orWhere('publisher','like', "%{$keyword}%");
            });
        }

        // ジャンル
        if($request->filled('genre_id')){
            $query->where('genre_id', $request->genre_id);
        }

        // ステータス
        if($request->filled('status')){
            $query->where('status', $request->status);
        }


        //許可するソートオプション　（キー：表示よう識別子、値：[カラム、昇降]）
        $sortOptions = [
            'created_at_desc'  => ['created_at', 'desc'],
            'created_at_asc'   => ['created_at', 'asc'],
            'title_desc'       => ['title', 'desc'],
            'title_asc'        => ['title', 'asc'],
            'author_desc'      => ['author', 'desc'],
            'author_asc'       => ['author', 'asc'],
            'finished_at_desc' => ['finished_at', 'desc'],
            'finished_at_asc'  => ['finished_at', 'asc'],
        ];

        // リクエストから受け取り、許可リストになければデフォルト
        $sort = $request->input('sort', 'created_at_desc');
        [$column, $direction] = $sortOptions[$sort] ?? $sortOptions['created_at_desc'];

        $books = $query->orderBy($column, $direction)->get();

        return view('books.index', [
            'books'    => $books,
            'genres'   => Genre::orderBy('id')->get(),
            'statuses' => BookStatus::cases(),
            'filters'  => $request->only(['keyword','genre_id','status','sort']),
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

        return response()->json([
            'status' => $book->status->value,
            'badgeClass' => $book->status->badgeClass(),
            ]);
    }
}
