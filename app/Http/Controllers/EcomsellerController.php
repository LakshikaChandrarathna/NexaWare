<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\CompanyContact;
use App\Models\CompanyEmail;

class EcomsellerController extends Controller
{
    public function index(Request $req)
{
 
    $companies = Company::with(['emails', 'contacts'])->where('isDelete', 0)->get();

    return view('seller.sellerprofile', compact('companies')); 
}
    public function store(Request $req)
    {
        
        $req->validate([
            'company_name'  => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'brc_number'    => 'required|string|max:255',
            'email'         => 'required|email',
            'province'      => 'required|string',
            'district'      => 'required|string',
            'gn_division'   => 'required|string',
            'building_no'   => 'required|string',
            'address_lines' => 'required|array',
            'contacts'      => 'required|array'
        ]);

        DB::beginTransaction();

        try {
            
            $fullAddress = implode(', ', $req->address_lines);

            
            $company = Company::create([
                'country'       => 'sri lanka',
                'country_id'    => 1,   
                'business_type' => $req->business_type,
                'company_name'  => $req->company_name,
                'com_code'      => 0,
                'brc_no'        => $req->brc_number,
                'province'      => $req->province,
                'district'      => $req->district,
                'gn_division'   => $req->gn_division,
                'house_no'      => $req->building_no,
                'address_lines' => $fullAddress, 
                'isDelete'      => 0
            ]);

            CompanyEmail::create([
                'company_id' => $company->id, 
                'email'      => $req->email,
                'is_primary' => 1 
            ]);


            if (!empty($req->contacts)) {
                foreach ($req->contacts as $index => $contact) {
                    if (!empty($contact['number'])) {
                        CompanyContact::create([
                            'company_id'   => $company->id, 
                            'contact_type' => $contact['type'], 
                            'contact_no'   => $contact['number'],
                            'country_code' => $contact['code'], 
                            'is_primary'   => ($index == 1) ? 1 : 0 
                        ]);
                    }
                }
            }

            DB::commit();

            return back()->with('success', 'Company registered successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        // 1. Validation Setup
        $request->validate([
            'company_name'   => 'required|string|max:255',
            'business_type'  => 'required|string|max:255',
            'brc_number'     => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'province'       => 'required|string',
            'district'       => 'required|string',
            'gn_division'    => 'required|string|max:255',
            'building_no'    => 'required|string|max:255',
            'address_lines'  => 'required|array',
            'address_lines.*'=> 'required|string|max:255',
            'contacts'       => 'required|array',
            'contacts.*.type'=> 'required|string|in:mobile,office',
            'contacts.*.code'=> 'required|string',
            'contacts.*.number' => 'required|string|max:20',
        ]);

        DB::beginTransaction();

        try {
            $company = Company::findOrFail($id);

            $company->update([
                'company_name'  => $request->company_name,
                'business_type' => $request->business_type,
                'brc_number'    => $request->brc_number,
                'email'         => $request->email,
                'province'      => $request->province,
                'district'      => $request->district,
                'gn_division'   => $request->gn_division,
                'building_no'   => $request->building_no, 
                'address_lines' => implode(', ', $request->address_lines),
            ]);


            $company->contacts()->delete(); 

            foreach ($request->contacts as $contactData) {
                $company->contacts()->create([
                    'contact_type' => $contactData['type'],
                    'country_code' => $contactData['code'],
                    'contact_no'   => $contactData['number'],
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Company details updated successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $company = Company::findOrFail($id);

            $company->update([
                'isDelete' => 1
            ]);

            return redirect()->back()->with('success', 'Company deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete company: ' . $e->getMessage());
        }
    }
}