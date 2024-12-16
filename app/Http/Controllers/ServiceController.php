<?php

namespace App\Http\Controllers;

use App\Models\Profile\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function addService(Request $request, $id){
        // Validate the request data
        $validatedData = $request->validate([
            'job_title' => 'required|string',
            'job_fee' => 'required|numeric',
            'fee_type' => 'required|string',
            'job_category' => 'required|string',
            'availability' => 'required|string',
        ]);

        //insert the record to the service table

        $service = new Service();

        $service->job_title = $request->job_title;
        $service->job_fee = $request->job_fee;
        $service->fee_type = $request->fee_type;
        $service->job_category = $request->job_category;

        // Determine if the service is available
        if (strtolower($request->availability) === 'available') {
            $service->isAvailable = true;
        } else {
            $service->isAvailable = false;
        }
        $service->freelancer_id = $id;

        $service->save();

        return redirect('/freelancer-settings');

    }

    public function deleteService(Service $service){

        $service->delete();

        return redirect()->back();
    }
}
