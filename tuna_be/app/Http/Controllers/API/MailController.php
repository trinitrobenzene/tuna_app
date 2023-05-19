<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send(Request $request)
    {
        $user = User::find($request->receiver_id);

        Mail::to($user['email'])->send(new TestMail($user));

        return "OKie";
    }
}
