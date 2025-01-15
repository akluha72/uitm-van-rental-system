<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return view('admin.payments.index', compact('payments'));
    }

    public function export()
    {
        // Use a library like Laravel Excel for exporting
        return Excel::download(new PaymentsExport, 'payments.xlsx');
    }
}
