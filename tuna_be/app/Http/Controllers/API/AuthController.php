<?php

namespace App\Http\Controllers\API;

use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout', 'me', 'register']]);
    }

    public function register(Request $request)
    {

        // return "OK";
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed"
        ], [
            "name.required" => "Vui lòng không bỏ trống tên.",
            "email.required" => "Vui lòng không bỏ trống email.",
            "email.email" => "Email không đúng định dạng.",
            "email.unique" => "Email đã được sử dụng.",
            "password.required" => "Vui lòng không bỏ trống mật khẩu.",
            "password.confirmed" => "Mật khẩu không khớp.",
        ]);

        $data = $request->except(['password', 'password_confirmation']);
        $data['password'] = Hash::make($request['password']);
        $user = User::create($data);

        $token = JWTAuth::attempt($request->only('email', 'password'));

        return response()->json([
            'token' => $token,
            'user' => $user
        ], Response::HTTP_OK);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ], [
            "email.required" => "Vui lòng không bỏ trống email.",
            "email.email" => "Email không đúng định dạng.",
            "password.required" => "Vui lòng không bỏ trống mật khẩu.",
        ]);

        $input = $request->only('email', 'password');

        if ($token = JWTAuth::attempt($input)) {
            return response()->json([
                'token' => $token,
                'user' => JWTAuth::user()
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Invalid Email or Password',
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // If the token is valid, return the user information
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (TokenExpiredException $e) {
            // Token is expired
            return response()->json([
                'success' => false,
                'message' => 'Token expired'
            ], 401);
        } catch (TokenInvalidException $e) {
            // Token is invalid
            return response()->json([
                'success' => false,
                'message' => 'Token invalid'
            ], 401);
        } catch (JWTException $e) {
            // Token is not provided
            return response()->json([
                'success' => false,
                'message' => 'Token not provided'
            ], 401);
        }
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return response()->json([
            'message' => 'User logged out successfully!'
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function refresh()
    // {
    //     return $this->respondWithToken($this->guard()->refresh());
    // }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => $this->guard()->factory()->getTTL() * 60
    //     ]);
    // }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    // public function guard()
    // {
    //     return Auth::guard();
    // }
}
