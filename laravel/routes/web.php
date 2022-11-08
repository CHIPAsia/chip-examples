<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

class Product
{
    public $id, $name, $description, $price, $color;

    public function __construct(int $id, string $name, string $description, int $price, string $color)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->color = $color;
    }
}

Route::get('/', function () {
    return view('welcome');
});
Route::get('/payment-fail', function () {
    return view('welcome', ['payment_status' => false]);
});
Route::get('/payment-success', function () {
    return view('welcome', ['payment_status' => true]);
});

Route::post('/donate', function (Request $request) {
    $inputs = $request->all();

    $client = new \Chip\Model\ClientDetails();
    $client->email = $inputs['client_email'];

    $product = new \Chip\Model\Product();
    $product->name = $inputs['client_name'];
    $product->price = $inputs['product_price'];

    $details = new \Chip\Model\PurchaseDetails();
    $details->products = [$product];

    $purchase = new \Chip\Model\Purchase();
    $purchase->client = $client;
    $purchase->purchase = $details;
    $purchase->brand_id = env('CHIP_BRAND_ID');
    $purchase->success_redirect = 'http://localhost/payment-success';
    $purchase->failure_redirect = 'http://localhost/payment-fail';

    $api = new \Chip\ChipApi(env('CHIP_BRAND_ID'), env('CHIP_API_KEY'), env('CHIP_ENDPOINT'));
    $result = $api->createPurchase($purchase);

    if ($result && $result->checkout_url) {
        // Redirect user to checkout
        return Redirect::to($result->checkout_url);
        exit;
    }
});
