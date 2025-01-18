<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user', 'booking')->get();
        return view('admin.payments', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with('', 'booking')->findOrFail($id);
        return response()->json($payment);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,pending,failed,refunded',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;
        $payment->save();

        return response()->json(['success' => true, 'message' => 'Payment status updated successfully.']);
    }

    public function export()
    {
        // Get the start and end of the current month
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();
    
        // Filter payments to only include those within the current month
        $payments = Payment::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
    
        $csvFileName = 'payments_' . now()->format('Y-m-d_H-i-s') . '.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$csvFileName}",
        ];
    
        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Payment ID', 'Booking ID', 'User Name', 'Amount', 'Status', 'Date']);
    
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->booking_id,
                    $payment->user->first_name ?? 'N/A', // Handle cases where user might be null
                    $payment->amount_paid,
                    $payment->payment_status,
                    $payment->created_at->format('Y-m-d'), // Format the date
                ]);
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    

}
