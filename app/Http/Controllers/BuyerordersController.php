<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ecomOrderReview;
use App\Models\cartItem;
use DB;
use App\Models\humans;
use App\Models\human_contacts;
use App\Models\human_emails;


class BuyerordersController extends Controller
{
     
public function storeReview(Request $request)
{
    
    $request->validate([
        'order_id' => 'required',
        'item_title' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:1000',
    ]);

  
    ecomOrderReview::create([
        'order_id' => $request->order_id, 
        'item_title' => $request->item_title,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);
    

    return redirect()->back()->with('success', 'Thank you for your feedback!');
}

     
 public function showOrders()
{
    $orders = cartItem::with(['human.contacts', 'human.emails']) 
                      ->where('human_id', auth()->id())
                      ->orderBy('created_at', 'desc')
                      ->get();
     
    return view('buyer.buyerorders', compact('orders'));
}


}



 
