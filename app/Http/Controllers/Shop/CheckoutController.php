<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\Variant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function index()
    {
        $accesToken = $this->generateAccessToken();
        $sessionToken = $this->generateSessionToken($accesToken);

        return view('shop.checkout.index', compact('sessionToken'));
    }

    public function generateAccessToken()
    {
        $url_api = config('services.niubiz.url_api') . '/api.security/v1/security';
        $user = config('services.niubiz.user');
        $password = config('services.niubiz.password');

        $auth = base64_encode($user . ':' . $password);

        return Http::withHeaders([
            'Authorization' => 'Basic ' . $auth,
        ])->get($url_api)
            ->body();
    }

    public function generateSessionToken($access_token)
    {
        $merchant_id = config('services.niubiz.merchant_id');
        $url_api = config('services.niubiz.url_api') . "/api.ecommerce/v2/ecommerce/token/session/{$merchant_id}";

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json'
        ])->post($url_api, [
            'channel' => 'web',
            'amount' => Cart::instance('shopping')->subtotal() + 15,
            'antifraud' => [
                'clientIp' => request()->ip(),
                'merchantDefineData' => [
                    'MDD4' => 'value4',
                    'MDD32' => 'value32',
                    'MDD75' => 'value75',
                    'MDD77' => 'value77',
                ]
            ]
        ])
        ->json();

        return $response['sessionKey'];
    }

    public function paid(Request $request)
    {
        $accesToken = $this->generateAccessToken();
        $merchant_id = config('services.niubiz.merchant_id');
        $url_api = config('services.niubiz.url_api') . "/api.authorization/v3/authorization/ecommerce/{$merchant_id}";

        $response = Http::withHeaders([
            'Authorization' => $accesToken,
            'Content-Type' => 'application/json'
        ])->post($url_api, [
            'channel' => 'web',
            'captureType' => 'manual',
            'countable' => 'true',
            'order' => [
                'tokenId' => $request->transactionToken,
                'purchaseNumber' => $request->purchaseNumber,
                'amount' => $request->amount,
                'currency' => 'PEN',
            ],
        ])->json();

        /* return $response; */

        session()->flash('niubiz', [
            'response' => $response,
            'purchaseNumber' => $request->purchaseNumber,
        ]);

        if(isset($response['dataMap']) && ($response['dataMap']['ACTION_CODE'] == '000')){

            $address = Address::where('user_id', Auth::user()->id)
                ->where('default', true)
                ->first();

            $order = Order::create([
                'user_id' => Auth::user()->id,
                'content' => Cart::instance('shopping')->content(),
                'address' => $address,
                'payment_id' => $response['dataMap']['TRANSACTION_ID'],
                'total' => Cart::instance('shopping')->subtotal() + 15,
            ]);
            
            foreach(Cart::instance('shopping')->content() as $item){
                Variant::where('sku', $item->options['sku'])
                    ->decrement('stock', $item->qty);
            }

            Cart::destroy();
            if (Auth::check()) {
                Cart::store(Auth::user()->id);
            }
            
            return redirect()->route('thanks')->with('order', $order);

        }

        return redirect()->route('checkout.index');
    }
}
