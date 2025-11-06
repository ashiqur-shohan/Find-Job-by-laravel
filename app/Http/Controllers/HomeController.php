<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class HomeController extends Controller
{
    // @desc Show home index view
    // @route GET / home
    public function index(){
        $jobs = Job::latest()->limit(6)->get();

        return view('pages.index')->with('jobs', $jobs);
    }
}
