<?php

namespace App\Http\Requests\Api\Thread;

use Illuminate\Foundation\Http\FormRequest;

class UpdateThreadRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:300'],
            'text' => ['required', 'string'],
            'subreddit_name' => ['string']
        ];
    }

    public function loggedUser()
    {
        return request()->user;
    }
}
