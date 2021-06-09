<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

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
}
