<?php

function getPaymentStatus($transaction) {
    $amountPaidTotal = $transaction->payment_proofs->sum('amount_paid');
    $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();

    if ($transaction->payment_status === 'Unpaid') {
        return '<span class="text-danger fw-bold">' . $transaction->payment_status . '</span>';
    } elseif ($latestPaymentProof && $latestPaymentProof->payment_type === 'Partial Payment' && $transaction->payment_status === 'Pending') {
        return '<span class="text-muted fw-bold">Partially Paid - ₱' . $amountPaidTotal . ' <small>(pending)</small></span>';
    } elseif ($transaction->payment_status === 'Partially Paid') {
        return '<span class="text-primary fw-bold">' . $transaction->payment_status . ' - ₱' . $amountPaidTotal . '</span>';
    } elseif ($latestPaymentProof && $latestPaymentProof->payment_type === 'Full Payment' && $transaction->payment_status === 'Pending') {
        return '<span class="text-muted fw-bold">Fully Paid - ₱' . $amountPaidTotal . ' <small>(pending)</small></span>';
    } elseif ($transaction->payment_status === 'Fully Paid') {
        return '<span class="text-success fw-bold">' . $transaction->payment_status . '</span>';
    }

    return '';
}