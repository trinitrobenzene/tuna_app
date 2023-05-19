<?php

namespace App\Http\Controllers\API;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        User::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email," . $id,
        ], [
            "name.required" => "Vui lòng không bỏ trống tên.",
            "email.required" => "Vui lòng không bỏ trống email.",
            "email.email" => "Email không đúng định dạng.",
            "email.unique" => "Email đã được sử dụng.",

        ]);

        if ($request['password']) {
            $request->validate(
                [
                    "password" => "required|confirmed"
                ],
                [
                    "password.required" => "Vui lòng không bỏ trống mật khẩu.",
                    "password.confirmed" => "Mật khẩu không khớp.",
                ]
            );
        }
        $user = User::find($id);
        if ($request['password']) {
            $user->update([
                "name" => $request['name'],
                "email" => $request['email'],
                "password" => Hash::make($request['password']),
            ]);
        }
        $user->update([
            "name" => $request['name'],
            "email" => $request['email']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
    }

    public function export(string $namefile)
    {
        return Excel::download(new UsersExport, $namefile . '.xlsx');
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only("email", "password"))) {
            return response(['message' => 'Invalid information!'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $request->user()->createToken("token");
        return $token;
    }
}
