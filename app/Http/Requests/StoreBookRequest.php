<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'      => ['required', 'string', 'max:255'],
            'author'     => ['required', 'string', 'max:255'],
            'publisher'  => ['nullable', 'string', 'max:255'],
            'genre_id'   => ['required', 'exists:genres,id'],
            'started_at' => ['nullable', 'date'],
            'finished_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'status'     => ['required', 'string'],
            'summary'    => ['nullable', 'string'],
            'impression' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'title.required'      => 'タイトルは必須です',
            'author.required'     => '著者は必須です',
            'genre_id.required'   => 'ジャンルを選択してください',
            'status.required'     => 'ステータスを選択してください',
            'finished_at.after_or_equal' => '読了日は読書開始日以降にしてください',
        ];
    }
}
