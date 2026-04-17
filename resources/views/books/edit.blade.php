@extends('layouts.app')

@section('title', $book->title.'- 編集')

@section('content')
<div class="mb-4">
    <a href="{{route('books.show', $book)}}" class="text-blue-600 hover:underline text-sm">← 詳細に戻る</a>
</div>

<h1 class="text-2xl font-bold mb-6">書籍編集</h1>

<form action="{{route('books.update', $book)}}" method="post" class="bg-white rounded-md shadow-sm p-6 space-y-5">
    @csrf
    @method('PUT')
    @include('books._form', ['book' => $book])

    <div class="flex justify-end gap-2 pt-4 border-t border-gray-200">
        <a href="{{route('books.show', $book)}}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm">
            キャンセル
        </a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
            更新する
        </button>
    </div>
</form>
@endsection
