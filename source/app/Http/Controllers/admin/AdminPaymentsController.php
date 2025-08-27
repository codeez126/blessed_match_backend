<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\UserPayment;
use Illuminate\Http\Request;

class AdminPaymentsController extends Controller
{
    public function pending()
    {
        $pending = UserPayment::with(['paymentPlan', 'paymentPlanVariation'])
            ->where('status', 0)
            ->orderBy('id', 'asc')
            ->get();
//        dd($pending);exit();
       return view('admin.payments.pending', compact('pending'));

    }
}
