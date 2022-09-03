<?php

namespace App\Http\Requests\Api\Thread;

use Illuminate\Foundation\Http\FormRequest;

class PublishThreadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'subreddit_name' => ['required', 'string']
        ];
    }
}
