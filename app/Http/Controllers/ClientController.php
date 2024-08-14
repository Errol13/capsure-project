<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all clients from the database
        $clients = Client::all();
        // Pass the clients data to the index view
        return view('clients.index', compact('clients'));
    }

    /**
     * Display the specified client.
     *
     * @param  int  
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Find the client by ID or fail if not found
        $client = Client::findOrFail($id);
        // Pass the client data to the show view
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for creating a new client.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Return the view for creating a new client
        return view('clients.create');
    }

    /**
     * Store a newly created client in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'total_job_posted' => 'required|integer',
            'total_successful_hiring' => 'required|integer',
            'hiring_rate' => 'required|numeric|between:0,9.99',
            'avg_rating' => 'required|numeric|between:0,9.99',
            'favorites' => 'nullable|integer',
        ]);

        // Create a new client record in the database
        Client::create($request->all());
        // Redirect to the clients index page
        return redirect()->route('clients.index');
    }

    /**
     * Show the form for editing the specified client.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Find the client by ID or fail if not found
        $client = Client::findOrFail($id);
        // Pass the client data to the edit view
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified client in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'total_job_posted' => 'required|integer',
            'total_successful_hiring' => 'required|integer',
            'hiring_rate' => 'required|numeric|between:0,9.99',
            'avg_rating' => 'required|numeric|between:0,9.99',
            'favorites' => 'nullable|integer',
        ]);

        // Find the client by ID or fail if not found
        $client = Client::findOrFail($id);
        // Update the client record in the database
        $client->update($request->all());
        // Redirect to the clients index page
        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified client from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Delete the client record from the database
        Client::destroy($id);
        // Redirect to the clients index page
        return redirect()->route('clients.index');
    }
}
