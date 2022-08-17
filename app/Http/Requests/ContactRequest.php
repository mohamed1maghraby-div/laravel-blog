<?php

namespace App\Http\Requests;

use Stevebauman\Purify\Facades\Purify;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'title' => 'required|min:5',
            'message' => 'required|min:10'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'message' => Purify::clean($this->message)
        ]);
    }
}
