<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ValidateController extends Controller
{
    public function showValidPhone()
    {
        return view('validation.validphone');
    }

    public function showValidID()
    {
        return view('validation.validID');
    }

    public function validateIdStore(Request $request)
    {

        Log::info("Gregorio");
        // Validate the incoming request
        $request->validate([
            'id_type' => 'required|string',
            'id_card_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pic_with_id' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

       
        // Store the uploaded ID photo
        $idCardImagePath = $request->file('id_card_image')->store('uploads/id_cards', 'public');

        // Store the selfie with ID
        $selfieWithIdPath = $request->file('pic_with_id')->store('uploads/selfies', 'public');

        // Create a new verification record
        DB::table('verifications')->updateOrInsert(
            ['user_id' => auth()->id()], // Ensure that it updates if the user already exists
            [
                'id_type' => $request->id_type,
                'id_card_image' => $idCardImagePath,
                'pic_with_id' => $selfieWithIdPath,
                'updated_at' => now(), // Update the timestamp
            ]
        );

        Log::info("ID is saved!");

        if (auth()->user()->user_type == 'client') {
            redirect()->route('client-settings');
        } elseif (auth()->user()->user_type == 'freelancer') {
            redirect()->route('freelancer-settings');
        }
    }
}
