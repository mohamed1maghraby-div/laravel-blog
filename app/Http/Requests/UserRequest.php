<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            default => $this->store(),
        };
    }

    protected function store()
    {
        return [
            'name' => 'required',
            'username' => 'required|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|numeric|unique:users',
            'status' => 'required',
            'bio' => 'nullable|min:10',
            'email_verified_at' => 'nullable',
            'receive_email' => 'nullable|numeric',
            'password' => 'required|min:8',
        ];
    }

    protected function update()
    {
        $url = explode('/', $this->url());
        return [
            'name' => 'required',
            'username' => 'required|max:20|unique:users,username,' . $url[5],
            'email' => 'required|email|max:255|unique:users,email,' . $url[5],
            'mobile' => 'required|numeric|unique:users,mobile,' . $url[5],
            'status' => 'required',
            'bio' => 'nullable|min:10',
            'receive_email' => 'nullable|numeric',
            'password' => 'nullable|min:8',
        ];
    }

    protected function prepareForValidation()
    {
        if($this->isMethod('POST')){
            $this->merge([
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt($this->password)
            ]);
        }else{
            $this->merge([
                'password' => bcrypt($this->password)
            ]);
        }
    }
}
