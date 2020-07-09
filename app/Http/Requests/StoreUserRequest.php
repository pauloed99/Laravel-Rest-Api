<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'cpf' => 'required|unique:App\User,cpf|min:11|max:14',
            'email' => 'required|unique:App\User,email',
            'password' => 'required|min:8',
            'password2' => 'required|min:8|same:password'
        ];
    }
}
