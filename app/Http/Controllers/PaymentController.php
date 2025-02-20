<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function redirectToPayment()
    {
        // Logic before redirection (e.g., check user balance, store session)
        return redirect('/dashboard'); // Change to your actual payment route
    }
}
