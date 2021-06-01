<?php


namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'email',
//            'avatar' => 'nullable|sometimes|image|mimes:jpeg,jpg,png'
        ];
    }
}
