<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Review;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    //write review 
    public function writeReview(Request $request, $transaction_id)
    {

        Log::info('Request Data: ', $request->all());
        $validatedData = $request->validate([
            'reviewee_role' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:300',
            'review_date' => 'required|date',
            'client_id' => 'required|exists:clients,user_id',
            'freelancer_id' => 'required|exists:freelancers,user_id',
        ]);

        Log::info('Review Data: ', $validatedData);

        // Create a new review
        Review::create([
            'transaction_id' => $transaction_id,
            'reviewee_role' => $validatedData['reviewee_role'],
            'rating' => $validatedData['rating'],
            'content' => $validatedData['content'],
            'review_date' => $validatedData['review_date'],
            'client_id' => $validatedData['client_id'],
            'freelancer_id' => $validatedData['freelancer_id'],
        ]);



        //update the transaction status to done
        $transaction = Transaction::findOrfail($transaction_id);

        //find out if both parties already did the review
        $freelancerRated = $transaction->reviews()->where('reviewee_role', 'freelancer')->exists();
        $clientRated = $transaction->reviews()->where('reviewee_role', 'client')->exists();

        $bothPartyRated = $freelancerRated && $clientRated;

        if($bothPartyRated){
            $transaction->update(['transaction_status' => 'Done']);
        }

      
        // Redirect back with success message
        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
