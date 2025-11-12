<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // @desc show all users job listings
    // @route GET /dashboard
    public function index(){
        // Get logged in user
        $user = Auth::user();

        // get the user listings
        $jobs = Job::where('user_id', $user->id)->get();
        
        return view('dashboard.index',compact('user','jobs'));
    }
}
