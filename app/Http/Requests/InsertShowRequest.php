<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertShowRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'nullable|date',
            'rating' => 'nullable|numeric|min:0|max:10',
            'status' => 'nullable|string|in:to watch,watching,finished',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5124',
            'genre_ids' => 'required|array|min:1', 
            'genre_ids.*' => 'exists:genres,id',   
        ];
    }
}
