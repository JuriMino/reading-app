@extends('layouts.app')

@section('title', '書籍一覧')

@section('content')
    <h1 class="text-2xl font-bold mb-6">書籍一覧</h1>

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
                                <select class="status-select border border-gray-300 rounded-md px-2 py-1 text-sm"
                                    data-book-id="{{ $book->id }}">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->value }} @selected($book->status === $status)">
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
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
