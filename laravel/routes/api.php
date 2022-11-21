<?php

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/callback/payment-success', function (Request $request) {
    $signature = $request->header('X-Signature');
    $content = $request->getContent();

    // get public key
    $response = Http::withHeaders([
        'Authorization' => "Bearer " . env('CHIP_API_KEY')
    ])->get("https://gate.chip-in.asia/api/v1/public_key/");
    $response_body = strval($response->body());

    // need to stich pub_key manually else will get error 
    // => openssl_verify(): Supplied key param cannot be coerced into a public key
    $response_arr = explode('\n', $response_body, -1);
    array_shift($response_arr);
    array_pop($response_arr);
    $response_arr_flat = "";
    foreach ($response_arr as $string) {
        $response_arr_flat .= $string . "\n";
    }
    $pub_key = "-----BEGIN PUBLIC KEY-----\n" . $response_arr_flat . "-----END PUBLIC KEY-----\n";

    $is_verified = \Chip\ChipApi::verify($content, $signature, $pub_key);

    if (!$is_verified) {
        Log::warning("WEBHOOK: X-Signature Mismatch");
        return response()->json([
            'error' => 'X-Signature Mismatch'
        ], 400);
    }

    // Upon successfull verification, update transaction status in database if necessary
    // Update order & transaction status to 'purchase.paid'
    Log::info("CALLBACK: $request->id");
    $order = Order::where('txn_id', $request->id)->first();
    if ($order) {
        $order->status = $request->status;
        $order->save();
    }

    Log::info("CALLBACK: X-Signature Ok!");
    return response()->json([
        'status' => 'CALLBACK: OK',
    ]);
});

Route::post('/webhook/payment', function (Request $request) {
    $signature = $request->header('X-Signature');
    $content = $request->getContent();
    $event = $request->input('event_type');
    $pub_key = env('CHIP_PUBLIC_KEY_FOR_WEBHOOK');

    $is_verified = \Chip\ChipApi::verify($content, $signature, $pub_key);

    if (!$is_verified) {
        Log::warning("WEBHOOK: X-Signature Mismatch");

        return response()->json([
            'error' => 'X-Signature Mismatch'
        ], 400);
    }

    // Upon successfull verification, update transaction status in database if necessary
    // Update order & transaction status to whatever the $event is
    Log::info("WEBHOOK: $request->id");
    $order = Order::where('txn_id', $request->id)->first();
    if ($order) {
        $order->status = $event;
        $order->save();
    }

    Log::info("WEBHOOK: X-Signature Ok!");
    return response()->json([
        'status' => 'WEBHOOK: OK',
    ]);
});
