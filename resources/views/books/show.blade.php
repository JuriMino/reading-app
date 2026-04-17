@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <div class="mb-4">
        <a href="{{ route('books.index') }}" class="text-blue-600 hover:underline text-sm">一覧に戻る</a>
    </div>

    <div class="bg-white rounded-md shadow-sm p-6 mb-6">
        <div class="flex items-start justify-between gap-4 mb-6">
            <div class="min-w-0 flex-1">
                <h1 class="text-2xl font-bold mb-1 break-words">{{ $book->title }}</h1>
                <p class="text-gray-600">{{ $book->author }}</p>
            </div>
            <div class="flex gap-2 shrink-0">
                <a href="{{ route('books.edit', $book) }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm whitespace-nowrap">
                    編集
                </a>
                <form action="{{ route('books.destroy', $book) }}" method="post"
                    onsubmit="return confirm('本当に削除してよろしいですか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-md text-sm whitespace-nowrap">
                        削除
                    </button>
                </form>
            </div>
        </div>
    </div>
    <dl class="grid grid-cols-2 gap-y-4 gap-x-8 mb-6">
        <div>
            <dt class="text-xs text-gray-500 mb-1">出版社</dt>
            <dd>{{ $book->publisher ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-xs text-gray-500 mb-1">ジャンル</dt>
            <dd>{{ $book->genre->name }}</dd>
        </div>
        <div>
            <dt class="text-xs text-gray-500 mb-1">読書開始日</dt>
            <dd>{{ $book->started_at?->format('Y-m-d') ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-xs text-gray-500 mb-1">読了日</dt>
            <dd>{{ $book->finished_at?->format('Y-m-d') ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-xs text-gray-500 mb-1">ステータス</dt>
            <dd>
                <select name="" id=""
                    class="status-select border border-gray-300 rounded-md px-3 py-2 text-sm"
                    data-book-id="{{ $book->id }}">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected($book->status === $status)>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </dd>
        </div>
    </dl>
    </div>
    <div class="bg-white rounded-md shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold mb-3">内容の要約</h2>
        <div class="text-gray-700 whitespace-pre-wrap">{{ $book->summary ?? '（未入力）' }}</div>
    </div>

    <div class="bg-white rounded-md shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-3">感想・メモ</h2>
        <div class="text-gray-700 whitespace-pre-wrap">{{ $book->impression ?? '（未入力）' }}</div>
    </div>
@endsection
