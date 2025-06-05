<?php

namespace App\Http\Controllers\Api\LMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        //dd($request->payment_method);
        $user = $request->user();
        $paymentMethod = $request->payment_method;

        $subscription = $user->newSubscription('default', 'price_1RUq6QPGrQCl3sZ3cg5fQUgU') // Replace with real price ID
        ->create($paymentMethod);

        return response()->json(['subscription' => $subscription]);
    }

    public function status()
    {
        $user = auth()->user();
        return response()->json([
            'subscribed' => $user->subscribed('default'),
            'onGracePeriod' => $user->subscription('default')?->onGracePeriod(),
            'endsAt' => $user->subscription('default')?->ends_at,
        ]);
    }

    public function invoices()
    {
        $invoices = auth()->user()->invoices();


        ; // returns collection of invoices from Stripe

        return response()->json([
            'invoices' => $invoices
        ]);
//        return response()->json([
//            'invoices' => $invoices->map(function ($invoice) {
//                return [
//                    'id' => $invoice->id,
//                    'total' => $invoice->total / 100,
//                    'date' => $invoice->date()->toDateString(),
//                    'status' => $invoice->paid ? 'paid' : 'unpaid',
//                    'download_url' => $invoice->invoice_pdf,
//                ];
//            })
//        ]);
    }
}
