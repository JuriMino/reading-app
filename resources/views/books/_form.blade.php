@if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 rounded-md p-4">
        <ul class="list-disc list-inline text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">タイトル <span class="text-red-500">*</span></label>
    <input type="text" name="title" id="title" value="{{ old('title', $book?->title )}}"
           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
</div>
<div>
    <label for="author" class="block text-sm font-medium text-gray-700 mb-1">著者 <span class="text-red-500">*</span></label>
    <input type="text" name="author" id="author" value="{{ old('author', $book?->author )}}"
           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
</div>
<div>
    <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">出版社</label>
    <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book?->publisher )}}"
           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
</div>
<div>
    <label for="genre_id"
           class="block text-sm font-medium text-gray-700 mb-1">ジャンル <span class="text-red-500">*</span>
    </label>
    <select name="genre_id" id="genre_id"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <option value="">選択してください</option>
        @foreach ($genres as $genre)
            <option value="{{ $genre->id }}" @selected(old('genre_id', $book?->genre_id) === $genre->id)>
                {{$genre->name}}
            </option>
        @endforeach
    </select>
</div>
<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="started_at" class="block text-sm font-medium text-gray-700 mb-1">読書開始日</label>
        <input type="date" name="started_at" id="started_at"
               value="{{ old('started_at', $book?->started_at?->format('Y-m-d')) }}"
               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
        <label for="finished_at" class="block text-sm font-medium text-gray-700 mb-1">読了日</label>
        <input type="date" name="finished_at" id="finished_at"
               value="{{ old('finished_at', $book?->finished_at?->format('Y-m-d')) }}"
               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    </div>
</div>
<div>
    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">ステータス <span class="text-red-500">*</span></label>
    <select name="status" id="status"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        @foreach ($statuses as $status)
            <option value="{{ $status->value }}" @selected(old('status', $book?->status?->value) === $status->value)>
                {{$status->label()}}
            </option>
        @endforeach
    </select>
</div>
<div>
    <label for="summary" class="block text-sm font-medium text-gray-700 mb-1">内容の要約</label>
    <textarea name="summary" id="summary" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('summary', $book?->summary )}}</textarea>
</div>
<div>
    <label for="impression" class="block text-sm font-medium text-gray-700 mb-1">感想・メモ</label>
    <textarea name="impression" id="impression" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('impression', $book?->impression )}}</textarea>
</div>
