<?php


namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'email|max:50',
            'username' => 'max:20',
            'name' => 'max:20',
            'lastname' => 'max:20',
//            'avatar' => 'nullable|sometimes|image|mimes:jpeg,jpg,png'
        ];
    }
}
