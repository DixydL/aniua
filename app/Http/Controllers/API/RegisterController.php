<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\LoginRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Model\PasswordReset;
use App\Notifications\PasswordResetRequest;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    /**
    * @OA\Post(
    *  path="/api/user/register",
    *  tags={"User"},
    *  @OA\RequestBody(
    *     request="UserArray",
    *     description="List of user object",
    *     required=true,
    *     @OA\JsonContent(ref="#/components/schemas/RegisterDataRequest")
    *  ),
    *  @OA\Response(
    *     response=200,
    *     description="successful operation",
    *  )
    * )
    */
    public function register(RegisterRequest $request)
    {
        $input = $request->input();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;

        $user->api_token = $success['token'];

        $user->save();


        $success['name'] = $user->name;
        $success['user_id'] = $user->id;
        $success['role'] = 5;
        $success['auth'] = 1;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
    * @OA\Post(
    *  path="/api/user/login",
    *  tags={"User"},
    *  @OA\RequestBody(
    *     request="UserArray",
    *     description="List of user object",
    *     required=true,
    *     @OA\JsonContent(ref="#/components/schemas/LoginDataRequest")
    *  ),
    *  @OA\Response(
    *     response=200,
    *     description="successful operation",
    *  )
    * )
    */
    public function login(LoginRequest $request)
    {
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $success['token'] = $user->createToken('MyApp')->accessToken;

            $user->api_token = $success['token'];
            $user->save();

            $success['name'] = $user->name;
            $success['user_id'] = $user->id;
            $success['role'] = 5;
            $success['auth'] = 1;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Пароль чи емейл введено некоректно'], 302);
        }
    }


    /**
     * Login through token
     *
     * @return \Illuminate\Http\Response
     */
    public function token(Request $request)
    {
        if ($user = User::where(['remember_token' => $request->token])->first()) {
            //$success['token'] = $user->createToken('MyApp')->accessToken;

            //$user->remember_token = $success['token'];
            //$user->api_token = $success['token'];
            //$user->save();

            $success['token'] = $user->remember_token;
            $success['name'] = $user->name;
            $success['user_id'] = $user->id;
            $success['role'] = 5;
            $success['auth'] = 1;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function passwordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', "=", $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => "На ваш емейл відправлений код",
            ], 200);
        }

        $secret = intval(rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9));

        PasswordReset::updateOrCreate([
                'email' => $request->input('email'),
                'secret' => $secret
        ]);

        $user->notify(
            new PasswordResetRequest($secret)
        );

        return response()->json([
            'message' => "На ваш емейл відправлений код",
        ], 200);
    }

    public function passwordResetCheck(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'secret' => 'required|integer',
        ]);

        $passwordReset = PasswordReset::where(['email' => $request->email, 'secret' => $request->secret])->first();

        if ($passwordReset) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('MyApp')->accessToken;

            $user->remember_token = $token;
            $user->save();

            $passwordReset->delete();
            return response()->json([
                'token' => $token,
                'message' => "Успіх",
            ], 200);
        }
        return response()->json([
            'message' => "Код відновлення не вірний",
        ], 422);
    }

    public function createNewPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            $success['token'] = $user->remember_token;
            $success['name'] = $user->name;
            $success['user_id'] = $user->id;
            $success['role'] = 5;
            $success['auth'] = 1;

            return $this->sendResponse($success, 'User login successfully.');
        }
    }
}
