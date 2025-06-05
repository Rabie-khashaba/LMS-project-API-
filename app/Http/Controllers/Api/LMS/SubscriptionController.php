<?php

namespace App\Http\Controllers\Api\LMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;

class SubscriptionController extends Controller
{
    public function purchase(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'amount' => 'required|numeric',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100, // بالدولار
                'currency' => 'usd',
                'source' => $request->token,
                'description' => 'Purchase Course',
            ]);

            return response()->json(['message' => 'Payment successful', 'charge' => $charge]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Payment failed', 'error' => $e->getMessage()], 500);
        }
    }
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
