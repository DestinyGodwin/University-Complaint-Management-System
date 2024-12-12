<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return auth()->user()->hasAnyRole(['admin', 'staff']);
    }

    public function rules()
    {
        return [
            'content' => 'required|string|max:1000',
        ];
    }
}
