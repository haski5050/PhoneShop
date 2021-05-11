<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class AdminController extends Controller
{
    public function adminLogin()
    {
        return view('auth.adminLogin');
    }

    public function adminLoginPost(Request $request)
    {
        $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:8'
        ]);

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
            return redirect()->route('homePage');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('homePage');
    }

    public function index(){
        return redirect()->route('homePage');
    }
}
