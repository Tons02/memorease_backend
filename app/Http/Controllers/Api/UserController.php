<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\SendDefaultCredentialsNotification;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;
    public function index(Request $request)
    {
        $status = $request->query('status');
        $pagination = $request->query('pagination');

        $users = User::with('role')
            ->when($status === 'inactive', function ($query) {
                $query->onlyTrashed();
            })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        if (!$pagination) {
            UserResource::collection($users);
        } else {
            $users = UserResource::collection($users);
        }
        return $this->responseSuccess('User display successfully', $users);
    }

    public function store(UserRequest $request)
    {
        $password = Str::random(6);
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
            "password" => $password,
            "role_id" => $request["role_id"],
        ]);

        $create_user->notify(new SendDefaultCredentialsNotification($password));

        return $this->responseCreated('User Successfully Created', $create_user);
    }

    public function update(UserRequest $request, $id)
    {
        $userID = User::find($id);

        if (!$userID) {
            return $this->responseUnprocessable('', 'Invalid ID provided for updating. Please check the ID and try again.');
        }

        $userID->fname = $request["fname"];
        $userID->mi = $request["mi"];
        $userID->lname = $request["lname"];
        $userID->suffix = $request["suffix"];
        $userID->gender = $request["gender"];
        $userID->mobile_number = $request["mobile_number"];
        $userID->birthday = $request["birthday"];
        $userID->address = $request['address'];
        $userID->email = $request['email'];
        $userID->role_id = $request['role_id'];

        if (!$userID->isDirty()) {
            return $this->responseSuccess('No Changes', $userID);
        }

        $userID->save();

        return $this->responseSuccess('Users successfully updated', $userID);
    }

    public function archived(Request $request, $id)
    {

        $user = User::withTrashed()->find($id);

        if (!$user) {
            return $this->responseUnprocessable('', 'Invalid id please check the id and try again.');
        }

        if ($user->deleted_at) {

            $user->restore();
            return $this->responseSuccess('user successfully restore', $user);
        }

        if (!$user->deleted_at) {

            $user->delete();
            return $this->responseSuccess('user successfully archive', $user);
        }
    }
}
