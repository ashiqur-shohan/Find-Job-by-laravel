<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Job;
class JobController extends Controller
{
    use AuthorizesRequests;

    // @desc Show all Job listings
    // @route GET / jobs
    public function index()
    {
        $jobs = Job::all();
        return view('jobs.index')->with('jobs', $jobs);
    }

    // @desc Show create job form
    // @route GET /jobs/create
    public function create()
    {
        return view('jobs.create');
    }

    // @desc Save job to database
    // @route POST /jobs
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'contact_logo' => 'nullable|image|mimes:jpeq,jpg,png,gif|max:2048',
            'contact_website' => 'nullable|url',

        ]);

        //hardcoded user id 
        $validateData['user_id'] = Auth::user()->id;

        //check for image
        if($request->hasFile('company_logo')){
            // Store the file and get path
            $path = $request->file('company_logo')->store('logos','public');

            //Add path to validated data
            $validateData['company_logo'] = $path;
        }

        // Submit to database
        Job::create($validateData);

        return redirect()->route('jobs.index')->with('success','Job Listing created successfully');
    }

    // @desc Display a single job listing
    // @route GET /jobs/{$id}
    public function show(Job $job)
    {
        return view('jobs.show')->with('job', $job);
    }

    // @desc Show edit job form
    // @route GET /jobs/{$id}/edit
    public function edit(Job $job)
    {
        // Check if user is authorized 
        $this->authorize('update',$job);
        
        return view('jobs.edit')->with('job',$job);
    }

    // @desc Update job listing
    // @route PUT /jobs/{$id}
    public function update(Request $request, Job $job)
    {
        // Check if user is authorized 
        $this->authorize('update',$job);

        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'contact_logo' => 'nullable|image|mimes:jpeq,jpg,png,gif|max:2048',
            'contact_website' => 'nullable|url',

        ]);

        //check for image
        if($request->hasFile('company_logo')){
            //delete old logo
            Storage::delete('public/logos/'.basename($job->company_logo));

            // Store the file and get path
            $path = $request->file('company_logo')->store('logos','public');

            //Add path to validated data
            $validateData['company_logo'] = $path;
        }

        // Submit to database
        $job->update($validateData);

        return redirect()->route('jobs.index')->with('success','Job Listing updated successfully');
    }

    // @desc Delete a job listing
    // @route DELETE /jobs/{$id}
    public function destroy(Job $job)
    {
        // Check if user is authorized 
        $this->authorize('delete',$job);

        // If logo, then delete it
        if($job->company_logo){
            Storage::disk('public')->delete($job->company_logo);
        }

        $job->delete();

        return redirect()->route('jobs.index')->with('success','Job listing deleted successfully!');
    }
}
