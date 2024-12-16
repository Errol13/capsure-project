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
        Log::info('Gregorio');

        // Validate the incoming request
        $request->validate([
            'id_type' => 'required|string',
            'id_card_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pic_with_id' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get the user ID
        $userId = auth()->id();

        // Process and store the ID card image with the original client name plus user ID as prefix
        $idCardOriginalName = $request->file('id_card_image')->getClientOriginalName();
        $idCardFilename = $userId . '_' . $idCardOriginalName;
        $idCardImagePath = $request->file('id_card_image')->storeAs('uploads/id_cards', $idCardFilename, 'public');

        // Process and store the selfie with ID with the original client name plus user ID as prefix
        $selfieOriginalName = $request->file('pic_with_id')->getClientOriginalName();
        $selfieFilename = $userId . '_' . $selfieOriginalName;
        $selfieWithIdPath = $request->file('pic_with_id')->storeAs('uploads/selfies', $selfieFilename, 'public');

        // Create or update a verification record
        DB::table('verifications')->updateOrInsert(
            ['user_id' => $userId],
            [
                'id_type' => $request->id_type,
                'id_card_image' => $idCardImagePath,
                'pic_with_id' => $selfieWithIdPath,
                'updated_at' => now(),
            ]
        );

        Log::info('ID is saved!');

        // Redirect based on user type
        if (auth()->user()->user_type == 'client') {
            return redirect()->route('client-settings');
        } elseif (auth()->user()->user_type == 'freelancer') {
            return redirect()->route('freelancer-settings');
        }
    }
}
