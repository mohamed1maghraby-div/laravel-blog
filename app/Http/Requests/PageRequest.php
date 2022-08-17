<?php

namespace App\Http\Requests;

use Stevebauman\Purify\Facades\Purify;
use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required|min:50',
            'status' => 'required',
            'category_id' => 'required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'description' => Purify::clean($this->description)
        ]);
    }
}
