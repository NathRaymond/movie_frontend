<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        try {
            $check = Contractor::where('name', $request->name)->first();
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
            $input['name'] = $input['name'];
            $input['phone_number'] = $input['phone_number'];
            $input['email'] = $input['email'];
            $input['sex'] = $input['sex'];
            $contractor = Contractor::create($input);

            return redirect()->back()->with('success', 'Contractor created successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
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
