<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function sendMail(Request $request)
    {
        $user = Customer::where('email', $request->input('email'))->firstOrFail();
        $passwordReset = PasswordReset::updateOrCreate([
            'email' => $user->email,
        ], [
            'token' => Str::random(60),
        ]);
        if ($passwordReset) {
            $to_email = $user->email;
            $subject = 'Lấy lại mật khẩu';
            $view = 'forgotpass';
            $data = [
                'token' => $passwordReset->token,
            ];
            Mail::to($to_email)->send(new SendEmail($subject, $view, $data));
        }
  
        return response()->json([
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }

    public function reset(Request $request, $token)
    {
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();

            return response()->json([
                'message' => 'This password reset token is invalid.',
            ], 422);
        }
        $user = Customer::where('email', $passwordReset->email)->firstOrFail();
        
        $updatePasswordUser = $user->update([
            "password" => Hash::make($request->input('password'))
        ]);
        $passwordReset->delete();

        return response()->json([
            'code' => 200,
            'success' => $updatePasswordUser,
        ]);
    }
}
