<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index(){
        return view('index');
    }
    public function checkout(){
        \Stripe\Stripe::setApiKey(config('stripe.sk'));
        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data'=>[
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => 'Send me money!!!',
                        ],
                        'unit_amount' => 500,
                    ],
                    'quantity' => 1,
                ],
            ],
            'model' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('index')
        ]);
        return redirect()->away($session->url);
    }

    public function success(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('index');
    }
}
