<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Province;
use App\Models\District;
use App\Models\GnDivision;
use App\Models\CartItem;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $seller = DB::table('humans')
            ->leftJoin('human_emails', function ($join) {
                $join->on('humans.id', '=', 'human_emails.human_id')
                    ->where('human_emails.is_primary', '=', 1);
            })
            ->leftJoin('human_contacts', function ($join) {
                $join->on('humans.id', '=', 'human_contacts.human_id')
                    ->where('human_contacts.is_primary', '=', 1);
            })
            // Joining Provinces, Districts, and GN Divisions
            ->leftJoin('provinces', 'humans.province', '=', 'provinces.id')
            ->leftJoin('districts', 'humans.discrict', '=', 'districts.id')
            ->leftJoin('g_n_divisions', 'humans.gndivision', '=', 'g_n_divisions.id')
            ->where('humans.id', $userId)
            ->select(
                'humans.*',
                'human_emails.email as registered_email',
                'human_contacts.contact_no as mobile_number',

                // Fetching names with clear aliases
                'provinces.p_name as province_name',
                'districts.d_name as district_name',
                'g_n_divisions.name_in_english as gn_division_name_en',
                'g_n_divisions.name_in_sinhala as gn_division_name_si',
                'g_n_divisions.name_in_tamil as gn_division_name_ta'
            )
            ->first();

        return view('seller.sellerprof', compact('seller'));
    }

    public function buyerprof(Request $request)
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $buyer = DB::table('humans')
            ->leftJoin('human_emails', function ($join) {
                $join->on('humans.id', '=', 'human_emails.human_id')
                    ->where('human_emails.is_primary', '=', 1);
            })
            ->leftJoin('human_contacts', function ($join) {
                $join->on('humans.id', '=', 'human_contacts.human_id')
                    ->where('human_contacts.is_primary', '=', 1);
            })
            ->leftJoin('provinces', 'humans.province', '=', 'provinces.id')
       
            ->leftJoin('districts', 'humans.discrict', '=', 'districts.id')
            ->leftJoin('g_n_divisions', 'humans.gndivision', '=', 'g_n_divisions.id')
            ->where('humans.id', $userId)
            ->select(
                'humans.*',
                'human_emails.email as registered_email',
                'human_contacts.contact_no as mobile_number',

                'provinces.p_name as province_name',
                'districts.d_name as district_name',
                'g_n_divisions.name_in_english as gn_division_name_en',
                'g_n_divisions.name_in_sinhala as gn_division_name_si',
                'g_n_divisions.name_in_tamil as gn_division_name_ta'
            )
            ->first();

        $provinces = DB::table('provinces')->get();

        return view('buyer.buyerprofile', compact('buyer', 'provinces'));
    }

    public function getDistricts($provinceId)
    {

        $districts = DB::table('districts')
            ->where('pro_id', $provinceId)
            ->get();

        return response()->json($districts);
    }


    public function getGNDivisions($districtId)
    {

        $gnDivisions = DB::table('g_n_divisions')
            ->where('dis_id', $districtId)
            ->get();

        return response()->json($gnDivisions);
    }

    public function submitProfile(Request $request)
    {

        $request->validate([
            'province' => 'required',
            'district' => 'required',
            'gn_division' => 'required',
            'house_no' => 'nullable|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
        ]);

        $userId = Auth::id();

        if ($userId) {

            DB::table('humans')
                ->where('id', $userId)
                ->update([
                    'province' => $request->province,
                    'discrict' => $request->district,
                    'gndivision' => $request->gn_division,
                    'house_no' => $request->house_no,
                    'addressone' => $request->address_line_1,
                    'addresstwo' => $request->address_line_2,
                    'updated_at' => now()
                ]);

            return redirect()->back()->with('success', 'Shipping details updated successfully!');
        }

        return redirect()->back()->with('error', 'User not found.');
    }

    public function dashboarddetails()
    {

        $recentOrders = CartItem::where('human_id', Auth::id())
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        $activeOrdersCount = CartItem::where('human_id', Auth::id())
            ->where('status','paid')
            ->whereIn('current_status', ['Processing', 'Shipped', 'Pending'])
            ->count();


        $totalCost = CartItem::where('human_id', Auth::id())
        ->where('status', 'paid')
        ->sum('total_price');


        $pointsEarned = floor($totalCost / 10);


        return view('buyer.buyerdashboard', compact('recentOrders', 'activeOrdersCount', 'totalCost', 'pointsEarned'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:10',
            'firstname' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile_number' => 'required|string|max:20',
        ]);

        $userId = Auth::id();

        if (!$userId) {
            return redirect()->back()->with('error', 'User not found.');
        }


        DB::table('humans')
            ->where('id', $userId)
            ->update([
                'title' => $request->title,
                'firstname' => $request->firstname,
                'surname' => $request->surname,
                'updated_at' => now()
            ]);


        DB::table('human_emails')->updateOrInsert(
            ['human_id' => $userId, 'is_primary' => 1],
            [
                'email' => $request->email,
                'updated_at' => now()
            ]
        );

        DB::table('human_contacts')->updateOrInsert(
            ['human_id' => $userId, 'is_primary' => 1],
            [
                'contact_type' => 'Mobile',
                'contact_no' => $request->mobile_number,
                'country_code' => '+94',
                'updated_at' => now()
            ]
        );

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    


}