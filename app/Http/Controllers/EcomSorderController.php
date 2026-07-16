<?php

namespace App\Http\Controllers;
use App\Models\CartItem;

use App\Models\Order;
use Illuminate\Http\Request;

class EcomSorderController extends Controller
{
    public function index(Request $req)
{
   
   $allPaidItems = CartItem::join('humans', 'cart_items.human_id', '=', 'humans.id')
   
    ->leftJoin('human_contacts', 'cart_items.human_id', '=', 'human_contacts.human_id')
   
    ->leftJoin('human_emails', 'cart_items.human_id', '=', 'human_emails.human_id')
    ->where('cart_items.status', 'paid')
    ->select([
        'cart_items.*', 
        'humans.fullname',
        'humans.addressone',
        'human_contacts.contact_no', 
        'human_emails.email'    
    ])
    ->orderBy('cart_items.created_at', 'desc')
    ->get();

    
    $groupedOrders = $allPaidItems->groupBy('order_id');


    $newOrders = $groupedOrders->filter(function ($items) {
        return $items->first()->current_status === 'new';
    });

    $ongoingOrders = $groupedOrders->filter(function ($items) {
        return in_array($items->first()->current_status, ['processing', 'shipped', 'in_transit']);
    });

    $completedOrders = $groupedOrders->filter(function ($items) {
        return $items->first()->current_status === 'delivered';
    });

    $returnOrders = $groupedOrders->filter(function ($items) {
        return in_array($items->first()->current_status, ['return_requested', 'pending_return', 'refunded']);
    });


    $counts = [
        'new'       => $newOrders->count(),
        'ongoing'   => $ongoingOrders->count(),
        'completed' => $completedOrders->count(),
        'returns'   => $returnOrders->count(),
    ];

    return view('seller.sellerorders', [
        'newOrders'       => $newOrders,
        'ongoingOrders'   => $ongoingOrders,
        'completedOrders' => $completedOrders,
        'returnOrders'    => $returnOrders,
        'counts'          => $counts
    ]);
}

public function dashboardview(Request $req)
{
    $allPaidItems = CartItem::join('humans', 'cart_items.human_id', '=', 'humans.id')
        ->leftJoin('human_contacts', 'cart_items.human_id', '=', 'human_contacts.human_id')
        ->leftJoin('human_emails', 'cart_items.human_id', '=', 'human_emails.human_id')
        ->leftJoin('items', 'cart_items.title' , '=' , 'items.item_name')
        ->where('cart_items.status', 'paid')
        ->select([
            'cart_items.*', 
            'humans.fullname',
            'humans.addressone',
            'human_contacts.contact_no', 
            'human_emails.email' ,
            'items.item_name' 
        ])
        ->orderBy('cart_items.created_at', 'desc')
        ->get();

    $groupedOrders = $allPaidItems->groupBy('order_id');

    $newOrders = $groupedOrders->filter(function ($items) {
        return strtolower($items->first()->current_status) === 'new';
    });

    $ongoingOrders = $groupedOrders->filter(function ($items) {
        return in_array(strtolower($items->first()->current_status), ['processing', 'shipped', 'in_transit']);
    });

    $completedOrders = $groupedOrders->filter(function ($items) {
        return strtolower($items->first()->current_status) === 'delivered';
    });

    $returnOrders = $groupedOrders->filter(function ($items) {
        return in_array(strtolower($items->first()->current_status), ['return_requested', 'pending_return', 'refunded']);
    });

    $lowStockThreshold = 5;
    $lowStockCount = \DB::table('grn_items')
        ->where('stock', '<', $lowStockThreshold)
        ->count();

    $totalRevenue = $allPaidItems->sum('total_price'); 
    $activeOrdersCount = $ongoingOrders->count() + $newOrders->count();

    $counts = [
        'revenue'   => $totalRevenue, 
        'active'    => $activeOrdersCount,
        'new'       => $newOrders->count(),
        'ongoing'   => $ongoingOrders->count(),
        'completed' => $completedOrders->count(),
        'returns'   => $returnOrders->count(),
        'low_stock' => $lowStockCount, 
    ];

    $recentOrders = $groupedOrders->take(10); 

    return view('seller.sellerdashboard', [
        'recentOrders' => $recentOrders,
        'counts'       => $counts
    ]);
}




}