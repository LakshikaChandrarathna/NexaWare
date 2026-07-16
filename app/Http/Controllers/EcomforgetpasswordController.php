<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Ecomforgetpassword;
 

class EcomforgetpasswordController extends Controller
{
    // STEP 1:  check mail andf send OTP
  
public function sendVerificationCode(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $email = $request->email;

  
    $emailExists = DB::table('human_emails')->where('email', $email)->exists();

    if (!$emailExists) {
        return response()->json(['success' => false, 'message' => 'The provided email address is not registered.'], 404);
    }

    // 2. generate a 6-digit OTP
    $otp = rand(100000, 999999);
    $expiresAt = Carbon::now()->addMinutes(10); 

    // 3. insert the OTP into the ecom_forget_passwords table
    DB::table('ecom_forget_passwords')->where('email', $email)->delete();
    DB::table('ecom_forget_passwords')->insert([
        'email' => $email,
        'token' => $otp,
        'expires_at' => $expiresAt,
        'created_at' => Carbon::now()
    ]);

    
 
        // 4. send the OTP to email  
        try {
            $data = ['otp' => $otp];
            view('mail.ecomforgetpasswordemail', $data)->render(); 
            
        
        Mail::send('mail.ecomforgetpasswordemail', $data, function ($message) use ($email) {
            $message->to($email)->subject('Password Reset Code - DBonda');
            });
            
          
            
            return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Failed to send email.',
                'error_details' => $e->getMessage()
            ], 500);
        }

}



    // STEP 2: check OTP and time validity
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6'
        ]);

        // check if the OTP exists for the given email and is valid
        $resetRow = DB::table('ecom_forget_passwords')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$resetRow) {
            return response()->json(['success' => false, 'message' => 'The entered code is incorrect.'], 400);
        }

        // check if the code has expired
        if (Carbon::now()->greaterThan($resetRow->expires_at)) {
            return response()->json(['success' => false, 'message' => 'This code has expired.'], 400);
        }

        return response()->json(['success' => true, 'message' => 'The code is valid.']);
    }

    // STEP 3: insert new password to humans table and delete the OTP from ecom_forget_passwords table
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
            'password' => 'required|min:8'
        ]);

        //  check if the OTP exists for the given email and is valid
        $resetRow = DB::table('ecom_forget_passwords')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$resetRow || Carbon::now()->greaterThan($resetRow->expires_at)) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired code. Please try again.'], 400);
        }



        
        DB::table('humans')
            ->join('human_emails', 'humans.id', '=', 'human_emails.human_id')
            ->where('human_emails.email', $request->email)
            ->update(['humans.password' => Hash::make($request->password)]);

        // 2.  delete the OTP from the ecom_forget_passwords table
        DB::table('ecom_forget_passwords')->where('email', $request->email)->delete();

        return response()->json(['success' => true, 'message' => 'Password reset successfully.']);
    }
}