<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Laravel\Fortify\Http\Requests\LoginRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Jobs\EmailSender;
use App\Mail\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class UserController extends ApiController
{
    public function getUserLogged() {
        return response()->json(['data' => Auth::user()]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $dataToUpdate = $request->except('avatar');
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = Auth::user()->id .'.'. $file->getClientOriginalExtension();
            $folder = 'avatars';
            $file->move(public_path($folder), $filename);
            $dataToUpdate['avatar'] = url("/$folder/$filename");
        }
        $user->update($dataToUpdate);
        return response()->json(['data' => $user]);
    }

    public function checkFieldExists(Request $request) {
        return response()->json(['data' => User::where($request->all())->exists()]);
    }

    public function handleSocialiteLogin(Request $request) {
        $driver = $request->route('driver');
        return Socialite::driver($driver)->stateless()->redirect();
    }

    public function handleSocialiteCallback() {
        $driver = request()->route('driver');
        $userDriver = Socialite::driver($driver)->stateless()->user();

        User::where('email', $userDriver->email)
            ->orWhere('username', $userDriver->name)
            ->delete();
        $password = Hash::make($userDriver->name);
        $user = User::create([
            'email' => $userDriver->email,
            'username' => $userDriver->name,
            'name' => $userDriver->name,
            'password' => $password,
            'lastname' => $userDriver->name,
            'avatar' => $userDriver->avatar,
        ]);

        EmailSender::dispatch([
            'class' => Register::class,
            'arguments' => [$user, 'emails.registerSocial'],
        ]);
        $spa = env('SPA_URL');
        return redirect("https://localhost:8080/es/login?socialregistered=$user->username");
    }
}
