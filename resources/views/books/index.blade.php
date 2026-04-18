@extends('layouts.app')

@section('title', '書籍一覧')

@section('content')
    <h1 class="text-2xl font-bold mb-6">書籍一覧</h1>
    {{-- 検索フォーム --}}
    <form action="{{ route('books.index') }}" method="get" class="bg-white rounded-md shadow-sm p-4 mb-4">
        <div class="grid grid-cols-12 gap-3 items-end">
            <div class="col-span-5">
                <label for="" class="block text-xs text-gray-500 mb-1">キーワード</label>
                <input type="text" name="keyword" value="{{ $filters['keyword'] ?? '' }}" placeholder="タイトル・著者・出版社"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
            </div>
        </div>
        <div class="col-span-3 mt-2">
            <label for="" class="block text-xs text-gray-500 mb-1">ジャンル</label>
            <select name="genre_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                <option value="">すべて</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}" @selected(($filters['genre_id'] ?? '') == $genre->id)>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-span-2 mt-2">
            <label for="" class="block text-xs text-gray-500 mb-1">ステータス</label>
            <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                <option value="">すべて</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') == $status->value)>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-span-2 flex mt-4">
            <button type="submit"
                class="flex-1/2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm mr-3">
                検索
            </button>
            <a href="{{ route('books.index') }}"
                class="flex-1/2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-md text-sm text-center ml-3">クリア</a>
        </div>
        <div class="mt-3 flex items-center justify-end gap-2">
            <label for="" class="text-xs text-gray-500">並び替え</label>
            <select name="sort" onchange="this.form.submit()"
                class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                <option value="created_at_desc" @selected(($filters['sort'] ?? 'created_at_desc') === 'created_at_desc')>登録日が新しい順</option>
                <option value="created_at_asc" @selected(($filters['sort'] ?? 'created_at_asc') === 'created_at_asc')>登録日が古い順</option>
                <option value="title_desc" @selected(($filters['sort'] ?? 'title_desc') === 'title_desc')>タイトル昇順</option>
                <option value="title_asc" @selected(($filters['sort'] ?? 'title_asc') === 'title_asc')>タイトル降順</option>
                <option value="author_desc" @selected(($filters['sort'] ?? 'author_desc') === 'author_desc')>著者昇順</option>
                <option value="author_asc" @selected(($filters['sort'] ?? 'author_asc') === 'author_asc')>著者降順</option>
                <option value="finished_at_desc" @selected(($filters['sort'] ?? 'finished_at_desc') === 'finished_at_desc')>読了日が新しい順</option>
                <option value="finished_at_asc" @selected(($filters['sort'] ?? 'finished_at_asc') === 'finished_at_asc')>読了日が古い順</option>

            </select>
        </div>
    </form>
    {{-- 新規登録ボタン --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('books.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            + 新規登録
        </a>
    </div>
    @if ($books->isEmpty())
        <div class="bg-white rounded-md shadow-sm p-8 text-center text-gray-500">
            まだ書籍が登録されていません。
            <a href="{{ route('books.create') }}" class="text-blue-600 hover:underline">新規登録</a>からどうぞ。
        </div>
    @else
        <div class="bg-white rounded-md shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">タイトル</th>
                        <th class="px-4 py-3 text-left">著者</th>
                        <th class="px-4 py-3 text-left">出版社</th>
                        <th class="px-4 py-3 text-left">ジャンル</th>
                        <th class="px-4 py-3 text-left">開始日</th>
                        <th class="px-4 py-3 text-left">読了日</th>
                        <th class="px-4 py-3 text-left">ステータス</th>
                        <th class="px-4 py-3 text-left">登録日</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tboby class="divide-y divide-gray-200">
                    @foreach ($books as $book)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:underline">
                                    {{ $book->title }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $book->author }}</td>
                            <td class="px-4 py-3">{{ $book->publisher }}</td>
                            <td class="px-4 py-3">{{ $book->genre->name }}</td>
                            <td class="px-4 py-3">{{ $book->started_at?->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">{{ $book->finished_at?->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">
                                <select
                                    class="status-select {{ $book->status->badgeClass() }} border rounded-full px-3 py-1 text-xs fpnt-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    data-book-id="{{ $book->id }}">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->value }}" @selected($book->status === $status)>
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-3">{{ $book->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('books.edit', $book) }}"
                                    class="text-gray-600 hover:text-blue-600 mr-3">編集</a>
                                <form action="{{ route('books.destroy', $book) }}" method="post" class="inline"
                                    onsubmit="return confirm('本当に削除してよろしいですか？')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-600 hover:text-red-600">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tboby>
            </table>
        </div>
    @endif
@endsection
