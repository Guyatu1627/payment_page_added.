<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AdminForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('admin.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:admins,username',
        ]);

        // Generate a random password
        $newPassword = bin2hex(random_bytes(4));

        // Find the user and update the password
        $admin = Admin::where('username', $request->username)->first();
        $admin->password = Hash::make($newPassword);
        $admin->save();

        // Send the new password back to the user via a success message
        return redirect()->route('admin.login')->with('status', "Your new password is: $newPassword");
    }
}
