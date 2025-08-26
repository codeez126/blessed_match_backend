<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\UserPayment;
use Illuminate\Http\Request;

class AdminPaymentsController extends Controller
{
    public function pending()
    {
        $pending =UserPayment::with('paymentPlan'. 'variations')->where('status', 0)->orderby('id', 'asc')->get();
       return view('admin.payments.pending', compact('pending'));

    }
}
