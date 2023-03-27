<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;

class ContractorController extends Controller
{
    public function contractor_index(Request $request)
    {
        $data['contractors'] = Contractor::all();
        return view('contractor.contractor_page', $data);
    }

    public function store_contractor(Request $request)
    {
        $check = Contractor::where('first_name', $request->first_name)->where('last_name', $request->last_name)->first();
        if ($check) {
            throw new \Exception('This Contractor name is already existing');
        }
        $check = Contractor::where('email', $request->email)->first();
        if ($check) {
            throw new \Exception('This Email is already existing');
        }
        $check = Contractor::where('phone_number', $request->phone_number)->first();
        if ($check) {
            throw new \Exception('This Phone Number is already existing');
        }
        $input = $request->all();
        $input['first_name'] = $input['first_name'];
        $input['last_name'] = $input['last_name'];
        $input['phone_number'] = $input['phone_number'];
        $input['email'] = $input['email'];
        $input['address'] = $input['address'];
        $input['sex'] = $input['sex'];
        $contractor = Contractor::create($input);

        return redirect()->back()->with('success', 'Contractor created successfully');
    }

    public function getcontractorInfor(Request $request)
    {
        $contractor = Contractor::where('id', $request->id)->first();
        return response()->json($contractor);
    }

    public function update_contractor(Request $request)
    {
        $contractor = Contractor::find($request->id);
        if ($contractor) {
            $input = $request->all();
            $contractor->fill($input)->save();
        }
        return redirect()->back()->with('success', 'contractor updated successfully');
    }

    public function destroy_contractor(Request $request)
    {
        $id = $request->id;
        Contractor::find($id)->delete();
        return redirect()->back()
            ->with('success', 'contractor deleted successfully');
    }
}
