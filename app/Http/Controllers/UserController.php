<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    use ResponseTrait;
    /**
     * Login user by employee ID and password.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserRequest $request)
    {
        try {
            // Attempt to log the user in
            if (Auth::attempt(['employee_id' => $request->employee_id, 'password' => $request->password])) {
                // Get the authenticated user
                $user = Auth::user();
                // Generate a token for the user (optional, if you are using API tokens)
                $token = $user->createToken('authToken')->accessToken;

                return  $this->sendSuccess($token,'Login successful');
            }
            return $this->sendError([], 'Unauthorized', 401);

        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError([], $th->getMessage(), 422);
        }
    }
}
