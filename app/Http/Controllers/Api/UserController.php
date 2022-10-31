<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get User profile
     * @return array
     */
    public function profile()
    {
        /** 
         * @var User $user
         */
        $user = $this->user();
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
        ];
    }

    public function update(ProfileRequest $request)
    {
        $password = $request->get('password') ? Hash::make($request->get('password')) : $this->user()->password;
        $this->user()->update(['password' => $password] + $request->validated());
        return response()->noContent();
    }

    private function user()
    {
        return Auth::user();
    }
}
