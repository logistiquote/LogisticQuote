<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'All Users | LogistiQuote';
        $data['page_name'] = 'all_users';

        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $data['users'] = $query->where('role', 'user')->get();

        return view('panels.admin.users', $data);
    }

    public function profile()
    {
        $data['page_title'] = 'Profile | LogistiQuote';
        $data['page_name'] = 'profile';
        $data['profile'] = User::findOrFail(Auth::user()->id);
        return view('panels.user.profile', $data);
    }
    public function update_profile(Request $request)
    {
        //Validate data
        $this->validate($request,[
            'name' => 'required|string|min:3|max:191',
            // 'email' => 'required|string|email|max:191',
            'phone' => 'required|string|min:9|max:20',
            'password' => 'nullable|min:6|max:191',
        ]);
        $user = User::findOrFail(Auth::user()->id);

        //Update password appropriately
        if($request->password != ""){
            $request->password = Hash::make($request->password);
        }
        else{
            $request->password = $user->password;
        }

        //Update record in User table
        $user->name = $request->name;
        $user->password = $request->password;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->back();
    }
}
