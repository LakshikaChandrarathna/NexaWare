<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; 
use App\Models\CartItem;
use App\Models\Human;
use App\Models\PaymentActiveConfirmations;
use App\Models\ecomPayments;
use Illuminate\Support\Facades\Mail;
use Exception;

class PayHereController extends Controller
{
     
    public function redirectToPayHere()
    {
        $human = null;
        $order_id = 'ORD-' . strtoupper(uniqid()); 
        $totalAmount = 0.00;

        if (Auth::check()) {
            $userId = Auth::id();

             
            $human = Human::with(['contacts', 'emails', 'district'])->find($userId);

             
            $latestCartItem = CartItem::where('human_id', $userId)
                                      ->whereNotNull('order_id')
                                      ->latest()
                                      ->first();

            if ($latestCartItem) {
                $order_id = $latestCartItem->order_id;
            }

             
            $totalAmount = CartItem::where('human_id', $userId)->sum('total_price');
        }

         
        if ($totalAmount <= 0) {
            $totalAmount = 100.00;  
        }

        if (Auth::check()) {
            DB::table('payment_active_confirmations')->updateOrInsert(
                ['order_id' => $order_id],
                [
                    'human_id' => Auth::id(),
                    'order_date' => now(),
                    'status' => 0, // 0 = pending
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        $formatted_amount = number_format((float)$totalAmount, 2, '.', '');
        
        
        $merchant_id = config('services.payhere.merchant_id');
        $merchant_secret = config('services.payhere.merchant_secret');
        $currency = 'LKR';

         
        $hash = strtoupper(md5($merchant_id . $order_id . $formatted_amount . $currency . strtoupper(md5($merchant_secret))));

        $primaryEmail = $human && $human->emails->first() ? $human->emails->first() : null;
        $primaryContact = $human && $human->contacts->first() ? $human->contacts->first() : null;

        return view('payhere', [
            'hash' => $hash,
            'order_id' => $order_id,
            'totalAmount' => $totalAmount,
            'formatted_amount' => $formatted_amount,
            'currency' => $currency,
            'human' => $human,
            'primaryEmail' => $primaryEmail,
            'primaryContact' => $primaryContact,
            'first_name' => $human->firstname ?? 'Customer',
            'last_name' => $human->surname ?? 'User',
            'email' => $primaryEmail->email ?? 'imadhigp@gmail.com',
            'phone' => $primaryContact->contact_no ?? '0771234567',
            'address' => 'Colombo, Sri Lanka',
            'city' => 'Colombo'
        ]);
    }

    public function initPay(Request $request)
    {
        
        $merchant_id = config('services.payhere.merchant_id');
        $merchant_secret = config('services.payhere.merchant_secret');
        $currency = 'LKR';
        $userId = Auth::id();

        $dbOrderId = Auth::check() ? CartItem::where('human_id', $userId)->whereNotNull('order_id')->latest()->value('order_id') : null;
        $dbTotal = Auth::check() ? CartItem::where('human_id', $userId)->sum('total_price') : 0.00;

        $order_id = $dbOrderId ?? $request->input('order_id', 'ORD-' . strtoupper(uniqid()));
        $totalAmount = $dbTotal > 0 ? (float)$dbTotal : (float)$request->input('totalAmount', 100.00);  
        
        $formatted_amount = number_format($totalAmount, 2, '.', '');

        $hash = strtoupper(md5($merchant_id . $order_id . $formatted_amount . $currency . strtoupper(md5($merchant_secret))));

        $human = null;
        if (Auth::check()) {
            $human = Human::with(['contacts', 'emails', 'district'])->find($userId);
        }

        $primaryEmail = $human && $human->emails->first() ? $human->emails->first() : null;
        $primaryContact = $human && $human->contacts->first() ? $human->contacts->first() : null;

        return view('payhere', [
            'hash' => $hash, 
            'order_id' => $order_id, 
            'totalAmount' => $totalAmount, 
            'formatted_amount' => $formatted_amount,
            'currency' => $currency,
            'email' => $request->input('email', $primaryEmail->email ?? ''), 
            'phone' => $request->input('phone', $primaryContact->contact_no ?? ''), 
            'first_name' => $request->input('first_name', $human->firstname ?? 'Customer'), 
            'last_name' => $request->input('last_name', $human->surname ?? 'User'),
            'address' => $request->input('address', ''),
            'city' => $request->input('city', ''),
            'human' => $human,
            'primaryEmail' => $primaryEmail,
            'primaryContact' => $primaryContact
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        return view('buyer.payment_success', [
            'order_id' => $request->input('order_id')
        ]);
    }

    public function paymentCancel(Request $request)
    {
        return view('buyer.payment_cancel');
    }

    public function paymentNotify(Request $request)
    {
         
        Log::info('PayHere IPN Received:', $request->all());

        $merchant_id      = $request->input('merchant_id');
        $order_id         = $request->input('order_id');
        $payhere_amount   = $request->input('payhere_amount', 0.00); 
        $payhere_currency = $request->input('payhere_currency');
        $status_code      = $request->input('status_code');
        $md5sig           = $request->input('md5sig');

        // 🛠️ FIX: env() වෙනුවට config() පාවිච්චි කර ඇත
        $merchant_secret  = config('services.payhere.merchant_secret', ''); 
        $formatted_amount = number_format((float)$payhere_amount, 2, '.', '');

         
        $local_md5sig = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                $formatted_amount . 
                $payhere_currency . 
                $status_code . 
                strtoupper(md5($merchant_secret))
            )
        );

         
        if ($local_md5sig !== $md5sig) {
            if (app()->environment('local')) {
                Log::warning("PayHere Hash Mismatch bypassed for local testing. Order: {$order_id}");
            } else {
                Log::critical("PayHere Hash Mismatch for Order: {$order_id}");
                return response("Invalid Signature", 400);
            }
        }

        try {
             
            $orderConfirmation = DB::table('payment_active_confirmations')->where('order_id', $order_id)->first();
            
            if (!$orderConfirmation) { 
                Log::error("Order Not Found in payment_active_confirmations: {$order_id}");
                return response()->json([
                    'status' => 'error',
                    'message' => "The order_id '{$order_id}' was not found in database."
                ], 404); 
            }
            
            $userId = $orderConfirmation->human_id;

            DB::table('payment_active_confirmations')
                ->where('order_id', $order_id)
                ->update([
                    'status' => $status_code,
                    'updated_at' => now()
                ]);

            switch ($status_code) {

                case 2:  // Success
                    DB::table('ecom_payments')->updateOrInsert(
                        ['human_id' => $userId, 'order_id' => $order_id],
                        [
                            'confirmation_id' => $orderConfirmation->id,
                            'amount'          => $payhere_amount,
                            'status'          => 'success',
                            'payment_date'    => now(),
                            'created_at'      => now(),
                            'updated_at'      => now()
                        ]
                    );

                    DB::table('cart_items')  
                        ->where('order_id', $order_id)
                        ->update([
                            'status'     => 'Paid',
                            'updated_at' => now()  
                        ]);


                    $customer = Human::with('emails')->find($userId);
                
                        if ($customer) {
                            $customerName = $customer->firstname ?? 'Customer';
                            $primaryEmailModel = $customer->emails->first();
                            $customerEmail = $primaryEmailModel ? $primaryEmailModel->email : null;

                            if ($customerEmail) {
                                try {
                                    
                                    Mail::send('mail.buyerOrderSuccessMail', [
                                        'name'    => $customerName, 
                                        'orderId' => $order_id, 
                                        'amount'  => $payhere_amount
                                    ], function ($message) use ($customerEmail) {
                                        $message->to($customerEmail)
                                                ->subject('Order Payment Success - DBonda');
                                    });

                                    Log::info("Order Success Mail Sent to: " . $customerEmail);

                                    
                                    \App\Models\ecomOrderSuccessMail::create([
                                        'name'   => $customerName,
                                        'email'  => $customerEmail,
                                        'status' => 'success',   
                                    ]);

                                } catch (\Exception $mailEx) {
                                    Log::error('Order Success Mail Failed: ' . $mailEx->getMessage());
                                    
                                    
                                    \App\Models\ecomOrderSuccessMail::create([
                                        'name'   => $customerName,
                                        'email'  => $customerEmail,
                                        'status' => 'failed',   
                                    ]);
                                }
                            } else {
                                Log::warning("Mail not sent. No email found for Human ID: " . $userId);
                            }
                }

                    Log::info("Payment Success Processed for Order: " . $order_id);
                    return response("Payment Success", 200);

                case 0:  // Pending
                    DB::table('ecom_payments')->updateOrInsert(
                        ['human_id' => $userId, 'order_id' => $order_id],
                        [
                            'confirmation_id' => $orderConfirmation->id,
                            'amount'          => $payhere_amount,
                            'status'          => 'pending',
                            'payment_date'    => now(),
                            'created_at'      => now(),
                            'updated_at'      => now()
                        ]
                    );

                     DB::table('cart_items')  
                        ->where('order_id', $order_id)
                        ->update([
                            'status'     => 'Pending',
                            'updated_at' => now()  
                        ]);

                    Log::info("Payment Pending Status Recorded for Order: " . $order_id);
                    return response("Payment Pending", 200);

                case -1: // Canceled
                    DB::table('ecom_payments')->updateOrInsert(
                        ['human_id' => $userId, 'order_id' => $order_id],
                        [
                            'confirmation_id' => $orderConfirmation->id,
                            'amount'          => $payhere_amount, 
                            'status'          => 'canceled',
                            'payment_date'    => now(),
                            'updated_at'      => now()
                        ]
                    );

                    DB::table('cart_items')  
                        ->where('order_id', $order_id)
                        ->update([
                            'status'     => 'Cancel',
                            'updated_at' => now()  
                        ]);

                    Log::info("Payment Cancelled for Order: " . $order_id);
                    return response("Payment Canceled", 200);

                case -2:  // Failed
                    DB::table('ecom_payments')->updateOrInsert(
                        ['human_id' => $userId, 'order_id' => $order_id],
                        [
                            'confirmation_id' => $orderConfirmation->id,
                            'amount'          => $payhere_amount,  
                            'status'          => 'failed',
                            'payment_date'    => now(),
                            'updated_at'      => now()
                        ]
                    );

                     DB::table('cart_items')  
                        ->where('order_id', $order_id)
                        ->update([
                            'status'     => 'Fail',
                            'updated_at' => now()  
                        ]);

                    Log::warning("Payment Failed Notice for Order: " . $order_id);
                    return response("Payment Failed", 200);

                default:
                    Log::warning("Unknown status code payload from PayHere: {$status_code}");
                    return response("Unknown Status", 200);
            }

        } catch (Exception $e) {
            
            Log::error("Database Error in paymentNotify: " . $e->getMessage());
            
            return response()->json([
                'status' => 'server_error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}