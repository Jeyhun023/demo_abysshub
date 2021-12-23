<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Events\NewUserRegisteredEvent;
use App\Models\User;
use App\Http\Resources\Auth\UserResource;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(RegisterRequest $request)
    {
        try {
            $user = new User([
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($request->password),
            ]);
            $user->save();
            
            event(new NewUserRegisteredEvent($user));

            return $this->successResponse(new UserResource($user), trans('messages.register_success'));
        } catch (Exception $e) {
            return $this->errorResponse(["failed" => [trans('messages.failed')] ]);
        }
        
    }
}
