<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Quotation;
use App\User;
use App\Proposal;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        //Specify required role for this controller here in checkRole:xyz
        $this->middleware(['auth', 'checkRole:admin', 'verified']); 
    }
    public function index()
    {
        $data['total_proposals'] = Proposal::count();
        $data['total_quotations'] = Quotation::count();
        $data['total_users'] = User::where('role', 'user')->count();
        $data['total_vendors'] = User::where('role', 'vendor')->count();
        $data['accepted_proposals'] = Proposal::where('status', 'completed')->count();
        $data['page_title'] = 'Dashboard | LogistiQuote';
        $data['page_name'] = 'dashboard';
        return view('panels.admin.dashboard', $data);
    }
    public function profile()
    {
        $data['page_title'] = 'Admin Profile | LogistiQuote';
        $data['page_name'] = 'profile';
        $data['profile'] = User::findOrFail(Auth::user()->id);
        return view('panels.admin.profile', $data);
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
    public function all_users()
    {
        $data['page_title'] = 'All Users | LogistiQuote';
        $data['page_name'] = 'all_users';
        $data['users'] = User::where('role', 'user')->get();
        return view('panels.admin.users', $data);
    }
    public function all_vendors()
    {
        $data['page_title'] = 'All Vendors | LogistiQuote';
        $data['page_name'] = 'all_vendors';
        $data['users'] = User::where('role', 'vendor')->get();
        return view('panels.admin.users', $data);
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

        return redirect(route('admin.all_users'));
    }
}
