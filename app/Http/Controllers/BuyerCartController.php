<?php
 
namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Province;
use App\Models\District;
use App\Models\City;
use App\Models\GNDivision;
use App\Models\ecomShippingDetails;
use App\Models\CartItem;
use App\Models\Human;
use App\Models\HumanEmail;
use App\Models\HumanContact;



class BuyerCartController extends Controller
{
    public function update(Request $request, $id)
    {
            $request->validate([
                'postal_code'   => 'required',
                'province'      => 'required',
                'cust_district' => 'required',
                'gn_division'   => 'required',
                'building_no'   => 'required',
                'address_line'  => 'required',  
            ]);

            $human = Human::find($id);

            if (!$human) {
                return response()->json(['success' => false, 'message' => 'Human not found!'], 404);
            }

            
            $human->province    = $request->input('province');
            $human->discrict    = $request->input('cust_district');  
            $human->gndivision  = $request->input('gn_division');
            $human->postal_code = $request->input('postal_code');
            $human->house_no    = $request->input('building_no');
            
            
            $human->addressone  = is_array($request->input('address_line')) 
                                ? implode(', ', $request->input('address_line')) 
                                : $request->input('address_line');

            $human->save();

        
            return response()->json([
                'success' => true,
                'message' => 'Shipping details updated successfully in database!'
            ]);
    }
    public function showCheckoutForm()
{
    $human = Human::with(['emails', 'contacts'])->find(auth()->id());

    $primaryEmail = $human?->emails->where('is_primary', 1)->first() ?? $human?->emails->first();
    $primaryContact = $human?->contacts->where('is_primary', 1)->first() ?? $human?->contacts->first();

    // 1. අලුත් Order ID එකක් සාදා ගැනීම
    $order_id = 'ORD-' . strtoupper(uniqid());

    // 2. දැනට 'new' තත්වයේ ඇති සියලුම items වලට එකම order_id එක update කිරීම
    CartItem::where('human_id', auth()->id()) // $human වෙනුවට auth()->id() යෙදුවා
            ->where('current_status', 'new')
            ->update(['order_id' => $order_id]);

    // Session එකටද දමා තැබීම
    session(['latest_order_id' => $order_id]);

    // 3. දැන් එම order_id එක තියෙන items ටික පමණක් load කරගැනීම (එවිට සියල්ලටම එකම order_id එකක් ඇත)
    $cartItems = CartItem::where('human_id', auth()->id())
                        ->where('order_id', $order_id)
                        ->where('current_status', 'new')
                        ->orderBy('created_at', 'desc')
                        ->get();

    $totalAmount = $cartItems->sum('total_price');
    $amount = $totalAmount;  
    $merchant = 'YOUR_MERCHANT_ID';  
    $merchant_id  = $merchant;
    $currency     = 'LKR';
    $merchant_secret = 'YOUR_MERCHANT_SECRET'; 

    $formatted_amount = number_format($amount, 2, '.', '');

    // PayHere Hash එක හැදීම
    $hash = strtoupper(
        md5(
            $merchant_id . 
            $order_id . 
            $formatted_amount . 
            $currency . 
            strtoupper(md5($merchant_secret))
        )
    );

    return view('buyer.buyercart', compact(
        'human', 
        'primaryEmail', 
        'primaryContact', 
        'cartItems', 
        'order_id', 
        'totalAmount',
        'merchant',
        'amount',  
        'hash'    
    ));
}

    public function showCheckoutFormex()
    {
           
            $human = Human::with(['emails', 'contacts'])->find(auth()->id());

            $primaryEmail = $human?->emails->where('is_primary', 1)->first() ?? $human?->emails->first();
            $primaryContact = $human?->contacts->where('is_primary', 1)->first() ?? $human?->contacts->first();


            $order_id = 'ORD-' . strtoupper(uniqid());

            CartItem::where('human_id', $human)
            ->where('current_status', 'new')
            ->update(['order_id' => $order_id]);
            // $order_id = session('latest_order_id', 'ORD-' . strtoupper(uniqid()));

            session(['latest_order_id' => $order_id]);
          

            
            $cartItems = CartItem::where('current_status', 'new')
                       
                        ->orderBy('created_at', 'desc')
                        ->get();

           

        
            $totalAmount = $cartItems->sum('total_price');
            $amount = $totalAmount;  
            $merchant = 'YOUR_MERCHANT_ID';  
            $merchant_id  = $merchant;
            $currency     = 'LKR';
            $merchant_secret = 'YOUR_MERCHANT_SECRET'; 

            
            $formatted_amount = number_format($amount, 2, '.', '');

        
            $hash = strtoupper(
                md5(
                    $merchant_id . 
                    $order_id . 
                    $formatted_amount . 
                    $currency . 
                    strtoupper(md5($merchant_secret))
                )
            );

        
            return view('buyer.buyercart', compact(
                'human', 
                'primaryEmail', 
                'primaryContact', 
                'cartItems', 
                'order_id', 
                'totalAmount',
                'merchant',
                'amount',  
                'hash'    
            ));
    }

   public function itemcard(Request $request)
{
    try {
        $items = $request->input('items');

        if (empty($items)) {
            return response()->json(['success' => false, 'message' => 'No items found in request'], 400);
        }

        $humanId = auth()->user()->id; 

        if (empty($humanId)) {
            return response()->json(['success' => false, 'message' => 'Human ID is required.'], 400);
        }

        

        foreach ($items as $item) {
            $price = $item['price'];
            $qty = $item['qty'];
            $totalPrice = $price * $qty;

            
            $sizeString = isset($item['sizes']) && is_array($item['sizes']) 
                ? implode(', ', $item['sizes']) 
                : ($item['size'] ?? 'N/A');

            CartItem::create([
                // 'order_id'      => $order_id,  
                'human_id'      => $humanId,  
                'title'         => $item['title'] ?? 'No Title',
                'image_url'     => $item['img'] ?? '',
                'quantity'      => $qty,
                'unit_price'    => $price,
                'total_price'   => $totalPrice,
                'size'          => $sizeString, 
                'color'         => $item['color'] ?? null,
                'current_status'=> 'new'
            ]);
        }

       

        return response()->json([
            'success' => true,
            // 'message' => 'All items saved successfully under Order ID: ' . $order_id
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function showCart(Request $request)
    {
        try {

            $order_id = session('latest_order_id');

            
            if ($order_id) {
                $cartItems = CartItem::where('order_id', $order_id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            } 
            
            else {
                $cartItems = collect();
            }
            
            
            $totalAmount = $cartItems->sum('total_price');

            $merchant = "YOUR_MERCHANT_ID";  
            $amount = $totalAmount;
            $hash = "GENERATED_HASH_HERE";  

        
            return view('buyer.buyercart', compact('cartItems', 'order_id', 'totalAmount', 'merchant', 'amount', 'hash'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteItem($id)
    {
        try {
        
            $cartItem = \App\Models\CartItem::findOrFail($id);
            $cartItem->delete();

            
            return redirect()->back()->with('success', 'Item removed from cart!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function getDistrictss($provinceId)
    {
        
        $districts = \App\Models\District::where('pro_id', $provinceId)
                        ->select('id', 'd_name')  
                        ->orderBy('d_name', 'asc')
                        ->get();

        return response()->json($districts);
    }

    public function getGnDivisionss($districtId)
    { 
        $gnDivisions = \App\Models\GNDivision::where('dis_id', $districtId)
                        ->select('id', 'name_in_english')  
                        ->orderBy('name_in_english', 'asc')
                        ->get();

        return response()->json($gnDivisions);
    }

    // public function itemcardex(Request $request)
    // {
    //         try {
    //             $items = $request->input('items');

    //             if (empty($items)) {
    //                 return response()->json(['success' => false, 'message' => 'No items found in request'], 400);
    //             }

    //             $humanId = auth()->user()->id; 

    //             if (empty($humanId)) {
    //                 return response()->json(['success' => false, 'message' => 'Human ID is required.'], 400);
    //             }

    //             $order_id = 'ORD-' . strtoupper(uniqid());

    //             foreach ($items as $item) {
    //                 $price = $item['price'];
    //                 $qty = $item['qty'];
    //                 $totalPrice = $price * $qty;

    //                 CartItem::create([
    //                     'order_id'       => $order_id,  
    //                     'human_id'       => $humanId,  
    //                     'title'          => $item['title'] ?? 'No Title',
    //                     'image_url'      => $item['img'] ?? '',
    //                     'quantity'       => $qty,
    //                     'size'           => $item['size'] ?? null,  
    //                     'color'          => $item['color'] ?? null, 
    //                     'unit_price'     => $price,
    //                     'total_price'    => $totalPrice,
    //                     'current_status' => 'new'
    //                 ]);
    //             }

    //             session(['latest_order_id' => $order_id]);

    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'All items saved successfully under Order ID: ' . $order_id
    //             ]);

    //         } catch (\Exception $e) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => $e->getMessage()
    //             ], 500);
    //         }
    // }


    
}
    
     