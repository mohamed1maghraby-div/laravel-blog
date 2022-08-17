<?php

namespace App\Http\Requests;

use Stevebauman\Purify\Facades\Purify;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\User\IndexController;

class CommentRequest extends FormRequest
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
        return match($this->method()){
            'PUT', 'PATCH' => $this->update(),
            default => $this->store()
        };
    }

    protected function store()
    {
        return [
            'name' => 'required',
            'url' => 'required|url',
            'email' => 'required|email',
            'comment' => 'required|min:10'
        ];
    }

    protected function update()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'url' => 'required|url',
            'status' => 'required',
            'comment' => 'required'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'comment' => Purify::clean($this->comment),
        ]);
    }
}
