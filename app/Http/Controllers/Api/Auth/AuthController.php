<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\Role;
use App\Models\User;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(Request $request)
    {

        $username = $request->username;
        $password = $request->password;

        $login = User::with([
            'role',
        ])->where('username', $username)->first();


        if (!$login || !hash::check($password, $login->password)) {
            return $this->responseBadRequest('', 'Invalid Credentials');
        }

        $permissions = $login->role->access_permission ?? [];
        $token = $login->createToken($login->role->name, $permissions)->plainTextToken;

        $cookie = cookie('authcookie', $token);

        return response()->json([
            'message' => 'Successfully Logged In',
            'token' => $token,
            'data' => $login
        ], 200)->withCookie($cookie);
    }

    public function Logout(Request $request)
    {
        $cookie = Cookie::forget('authcookie');
        auth('sanctum')->user()->currentAccessToken()->delete();
        return $this->responseSuccess('Logout successfully');
    }

    public function registration(RegistrationRequest $request)
    {
        $role = Role::where('name', 'customer')->first();

        if (!$role) {
            return $this->responseUnprocessable('Role is not setup please contact Support or Admin');
        }

        $create_user = User::create([
            "profile_picture" => "default_profile.jpg",
            "fname" => $request["fname"],
            "mi" => $request["mi"],
            "lname" => $request["lname"],
            "suffix" => $request["suffix"],
            "gender" => $request["gender"],
            "mobile_number" => $request["mobile_number"],
            "birthday" => $request["birthday"],
            "address" => $request["address"],
            "username" => $request["username"],
            "email" => $request["email"],
            "password" => $request["password"],
            "role_id" => $role->id,
        ]);

        // Dispatch email verification
        event(new Registered($create_user));

        $permissions = $create_user->role->access_permission ?? [];
        $token = $create_user->createToken($create_user->role->name, $permissions)->plainTextToken;

        $cookie = cookie('authcookie', $token);

        return response()->json([
            'message' => 'Registration successful. Please check your email to verify your account.',
            'token' => $token,
            'data' => $create_user
        ], 200)->withCookie($cookie);
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return $this->responseUnprocessable('', 'Invalid ID provided for updating password. Please check the ID and try again.');
        }

        $user->update([
            'password' => $user->username,
        ]);

        return $this->responseSuccess('The Password has been reset');
    }

    public function changedPassword(ChangePasswordRequest $request)
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return $this->responseUnprocessable('', 'Please make sure you are logged in');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return $this->responseSuccess('Password change successfully');
    }
}
