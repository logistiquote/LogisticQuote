<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Quotation;
use App\User;
use App\Proposal;
use Carbon\Carbon;

class VendorController extends Controller
{
    //
    public function __construct()
    {
        //Specify required role for this controller here in checkRole:xyz
        $this->middleware(['auth', 'checkRole:vendor', 'verified']); 
    }
    public function index()
    {
        $data['proposals_made'] = Proposal::where('partner_id', Auth::user()->id)->count();
        $data['accepted_proposals'] = Proposal::where('partner_id', Auth::user()->id)
        ->where('status', 'completed')->count();
        $data['active_proposals'] = Proposal::where('partner_id', Auth::user()->id)
        ->where('status', 'active')->count();
        $data['page_title'] = 'Dashboard | LogistiQuote';
        $data['page_name'] = 'ven_dashboard';
        return view('panels.ven.dashboard', $data);
    }
    public function profile()
    {
        $data['page_title'] = 'User Profile | LogistiQuote';
        $data['page_name'] = 'profile';
        $data['profile'] = User::findOrFail(Auth::user()->id);
        return view('panels.ven.profile', $data);
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
