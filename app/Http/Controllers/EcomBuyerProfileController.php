<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;   
use App\Models\GNDivision;  
use App\Models\EcomBuyerProfile;  
Use App\Models\Human;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class EcomBuyerProfileController extends Controller
{
    public function submitProfile(Request $request)
    {
        $request->validate([
            'province' => 'required',
            'district' => 'required',
            'gn_division' => 'required',
            'house_no' => 'required',
            'address_line_1' => 'required',
        ]);

        $provinceData = DB::table('provinces')->where('id', $request->province)->first();
        $districtData = DB::table('districts')->where('id', $request->district)->first(); 
        $gnDivisionData = DB::table('g_n_divisions')->where('id', $request->gn_division)->first();
 
        $profile = new \App\Models\EcomBuyerProfile();
        
        $profile->province = $provinceData ? $provinceData->p_name : null;
        $profile->district = $districtData ? $districtData->d_name : null; 
        $profile->gn_division = $gnDivisionData ? $gnDivisionData->name_in_english : null;

        $profile->house_no = $request->house_no;
        $profile->address_line_1 = $request->address_line_1;
        $profile->address_line_2 = $request->address_line_2;

        $profile->save();

        return redirect()->back()->with('success', 'Profile Details Saved Successfully with Names!');
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

public function updateShippingAddress(Request $request)
{
    $request->validate([
        'province'       => 'required',
        'district'       => 'required',
        'gn_division'    => 'required',
        'house_no'       => 'required',
        'address_line_1' => 'required', 
    ]);

    $profile = Human::where('id', Auth::id())->first();

    if (!$profile) {
        $profile = new Human();
        $profile->user_id = Auth::id();
    }

    $profile->province   = $request->province;    
    $profile->discrict   = $request->district;    
    $profile->gndivision = $request->gn_division; 

    $profile->house_no   = $request->house_no;
    $profile->addressone = $request->address_line_1; 
    $profile->addresstwo = $request->address_line_2; 

    $profile->save();

    return redirect()->back()->with('success', 'Shipping Address Updated Successfully!');
}


}