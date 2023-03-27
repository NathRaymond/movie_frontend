<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
// use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;

class UserController extends Controller
{
    public function user_index(Request $request)
    {
        $data['users'] = User::all();
        return view('user.user_page', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['user_type'] = 'admin';
        $user = User::create($input);

        return redirect()->back()->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    public function update_user(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required',
        ]);
        $input = $request->all();
        $user = User::find($id);
        $user->update($input);
        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function getUserInfor(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        return response()->json($user);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        User::find($id)->delete();
        return redirect()->back()
            ->with('success', 'User deleted successfully');
    }
}
