<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\PaymentProof;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;

class PaymentProofController extends Controller
{
    public function uploadPaymentProof(Request $request, $transactionId)
    {
        // Validate the form data
        $request->validate([
            'payment_type' => 'required|in:Partial Payment,Full Payment',
            'proof_file' => 'required|mimes:jpeg,png,jpg|max:15360', // maximum of 15MB only
        ]);

        $transaction = Transaction::findOrFail($transactionId);

        // Process the image and store in 'public/paymentproof'
        $filePath = null;
        if ($request->hasFile('proof_file')) {
            $file = $request->file('proof_file');
            $fileName = time() . '_' . $file->getClientOriginalName();  // Generate unique name
            $filePath = $file->storeAs('public/paymentproof', $fileName);  // Store file
        }

        // Store the file path in the database
        if ($filePath) {
            PaymentProof::create([
                'transaction_id' => $transaction->transaction_id,
                'file_path' => $filePath,
                'payment_type' => $request->input('payment_type'),
            ]);
        } else {
            return redirect()->back()->with('error', 'No file attachment!');
        }

        // Update transaction status
        $transaction->payment_status = 'Pending';
        $transaction->save();

        return redirect()->back()->with('message', 'Payment proof uploaded successfully.');
    }


    public function confirmPayment(Request $request, $transactionId)
    {
        // Validate payment_proof_id 
        $request->validate([
            'payment_proof_id' => 'required|exists:payment_proofs,proof_id',
        ]);

        // Fetch the transaction and the payment proof
        $transaction = Transaction::findOrFail($transactionId);
        $paymentProof = PaymentProof::findOrFail($request->input('payment_proof_id'));

        // Determine the confirmed status based on payment type
        $confirmedStatus = $paymentProof->payment_type === 'Partial Payment' ? 'Partially Paid' : 'Fully Paid';

        // Update the transaction status
        $transaction->update(['payment_status' => $confirmedStatus]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Payment confirmed successfully!');
    }
}
