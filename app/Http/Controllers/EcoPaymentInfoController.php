<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentInfo; 
use Illuminate\Support\Facades\Auth;

class EcoPaymentInfoController extends Controller
{

    public function paymentview()
    {
    
        $paymentInfo = PaymentInfo::where('user_id', Auth::id())->first();

   
        return view('buyer.buyerpayment', compact('paymentInfo'));
    }


    public function savePaymentInfo(Request $request)
    {
       
        $request->validate([
            'bank_name'           => 'required|string',
            'account_holder_name' => 'required|string|max:255',
            'card_number'         => 'required|string',
            'expire_date'         => 'required',
            'cvv'                 => 'required|string|max:4',
        ]);

        
        PaymentInfo::updateOrCreate(
            ['user_id' => Auth::id()], 
            [
                'bank_name'           => $request->bank_name,
                'account_holder_name' => $request->account_holder_name,
                'card_number'         => $request->card_number,
                'expire_date'         => $request->expire_date,
                'cvv'                 => $request->cvv, 
            ]
        );

       
        return redirect()->back()->with('success', 'Payment information updated successfully!');
    }
}