<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard() {

        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            return view('admin.dashboard', compact('user_data'));
        }
        return redirect()->route('login');

    }
}
