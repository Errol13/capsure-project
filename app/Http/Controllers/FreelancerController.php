<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    /**
     * Display a listing of freelancers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all freelancers from the database
        $freelancers = Freelancer::all();
        // Pass the freelancers data to the index view
        return view('freelancers.index', compact('freelancers'));
    }

    /**
     * Display the specified freelancer.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Find the freelancer by ID or fail if not found
        $freelancer = Freelancer::findOrFail($id);
        // Pass the freelancer data to the show view
        return view('freelancers.show', compact('freelancer'));
    }

    

    /**
     * Store a newly created freelancer in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'avg_rating' => 'required|numeric|between:0,9.99',
            'number_of_projects' => 'required|integer',
            'terms_and_conditions' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'nullable|string',
            'is_in_a_team' => 'required|boolean',
        ]);

        // Create a new freelancer record in the database
        Freelancer::create($request->all());
        // Redirect to the freelancers index page
        return redirect()->route('freelancers.index');
    }

    /**
     * Show the form for editing the specified freelancer.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Find the freelancer by ID or fail if not found
        $freelancer = Freelancer::findOrFail($id);
        // Pass the freelancer data to the edit view
        return view('freelancers.edit', compact('freelancer'));
    }

    /**
     * Update the specified freelancer in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'avg_rating' => 'required|numeric|between:0,9.99',
            'number_of_projects' => 'required|integer',
            'terms_and_conditions' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'nullable|string',
            'is_in_a_team' => 'required|boolean',
        ]);

        // Find the freelancer by ID or fail if not found
        $freelancer = Freelancer::findOrFail($id);
        // Update the freelancer record in the database
        $freelancer->update($request->all());
        // Redirect to the freelancers index page
        return redirect()->route('freelancers.index');
    }

    /**
     * Remove the specified freelancer from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Delete the freelancer record from the database
        Freelancer::destroy($id);
        // Redirect to the freelancers index page
        return redirect()->route('freelancers.index');
    }

    //show Myjobs

    public function myJobs(){

        return view('freelancer.f_myjobs');
    }
}
