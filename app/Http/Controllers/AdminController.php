<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $data['total_quotations'] = Quotation::count();
        $data['total_users'] = User::where('role', 'user')->count();
        $data['page_title'] = 'Dashboard | LogistiQuote';
        $data['page_name'] = 'dashboard';
        return view('panels.admin.dashboard', $data);
    }

    public function view_user($id)
    {
        $data['page_title'] = 'View User | LogistiQuote';
        $data['page_name'] = 'view_user';
        $data['profile'] = User::where('id', $id)->first();
        return view('panels.admin.user_profile', $data);
    }

    public function update_user_profile(Request $request)
    {
        //Validate data
        $this->validate($request,[
            'name' => 'required|string|min:3|max:191',
            // 'email' => 'required|string|email|max:191',
            'phone' => 'required|string|min:9|max:20',
            'password' => 'nullable|min:6|max:191',
        ]);
        $user = User::findOrFail($request->id);

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

        return redirect(route('users.list'));
    }
}
