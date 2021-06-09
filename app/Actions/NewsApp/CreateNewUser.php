<?php

namespace App\Actions\NewsApp;

use App\Actions\Fortify\PasswordValidationRules;
use App\Jobs\EmailSender;
use App\Mail\Register;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use \Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $unique = Rule::unique(User::class);
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                $unique,
            ],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', $unique],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'lastname' => $input['lastname'],
            'email' => $input['email'],
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
        ]);

        $user->enable2fa();

        EmailSender::dispatch([
            'class' => Register::class,
            'arguments' => [$user],
        ]);

        return $user;
    }
}
