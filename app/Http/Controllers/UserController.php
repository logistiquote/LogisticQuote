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

class UserController extends Controller
{
    //
    public function __construct()
    {
        //Specify required role for this controller here in checkRole:xyz
        $this->middleware(['auth', 'checkRole:user', 'verified']); 
    }
    public function index()
    {
        $data['my_quotations'] = Quotation::where('user_id', Auth::user()->id)->count();
        $data['received_proposals'] = Proposal::where('user_id', Auth::user()->id)->count();
        $data['completed_quotations'] = Quotation::where('user_id', Auth::user()->id)
        ->where('status', 'completed')->count();
        $data['active_quotations'] = Quotation::where('user_id', Auth::user()->id)
        ->where('status', 'active')->count();
        $data['page_title'] = 'Dashboard | LogistiQuote';
        $data['page_name'] = 'dashboard';
        return view('panels.user.dashboard', $data);
    }
    public function profile()
    {
        $data['page_title'] = 'User Profile | LogistiQuote';
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
    public function quotations()
    {
        $data['page_title'] = 'User Quotations | LogistiQuote';
        $data['page_name'] = 'quotations';
        $data['quotations'] = Quotation::where('user_id', Auth::user()->id)->get();

        return view('panels.user.quotations', $data);
    }
    public function add_quotation()
    {
        $data['page_title'] = 'Request a Quotation | LogistiQuote';
        $data['page_name'] = 'add_quotation';

        return view('panels.user.add_quotation', $data);
    }
}
