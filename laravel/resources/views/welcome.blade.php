<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel &times; Chip In</title>
    @vite('resources/css/app.css')
</head>

<body class="antialiased min-h-screen bg-base-200 preview" style="background-size:5px 5px;">
    <nav class="navbar bg-base-100 shadow-md">
        <div class="navbar-center">
            <a href="/" class="btn btn-ghost normal-case text-xl">Sample App</a>
        </div>
    </nav>
    <div class="p-2 sm:p-4 space-y-4">
        @if(isset(request()->status) && request()->status == "success")
        <div class="alert alert-success shadow-xl">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Your transaction has been confirmed!</span>
            </div>
        </div>
        @endif
        @if(isset(request()->status) && request()->status == "fail")
        <div class="alert alert-error shadow-xl">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Transaction failed successfully.</span>
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-error shadow-xl">
            <div class="px-6">
                <ul class="list-disc">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
            <div class="flex-1 min-h-12 card bg-base-100 shadow-md">
                <form method="POST" action="/payment" class="flex flex-col space-y-4 p-4 sm:p-8">
                    <div class="flex flex-row justify-between items-center">
                        <h3 class="text-2xl font-bold">Order Form</h3>
                        <div class="form-control">
                            <label class="label cursor-pointer gap-4">
                                <span class="label-text">Pay using Direct Post CC:</span>
                                <input type="checkbox" value="true" name="is_direct_post" class="toggle" id="is_direct_post" />
                            </label>
                        </div>
                    </div>
                    @csrf
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Product Name</span>
                        </label>
                        <input name="product_name" value="{{$product->title}}" type="text" placeholder="Your name" class="input input-bordered w-full @error('product_name') input-error @enderror" />
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Amount (RM)</span>
                        </label>
                        <input name="product_price" type="number" value="{{$product->price}}" class="input input-bordered w-full @error('product_price') input-error @enderror" />
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Your Email</span>
                        </label>
                        <input name="client_email" value="{{fake('ms_MY')->unique()->safeEmail()}}" type="email" placeholder="Your email" class="input input-bordered w-full @error('client_email') input-error @enderror" />
                    </div>

                    <div class="@error('product_name')  @else hidden @enderror" id="credit_card_form">
                        <div class="divider">
                            <h3 class="text-2xl font-bold">Credit Card</h3>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text"></span>
                            </label>
                            <input name="credit_card_no" value="4100000000000100" type="text" placeholder="Enter your credit card number. i.e: 1212232334344545" class="input input-bordered w-full @error('credit_card_no') input-error @enderror" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text"></span>
                            </label>
                            <div class="flex flex-row gap-4">
                                <select name="credit_card_month" class="select select-bordered flex-grow">
                                    <option disabled selected>Month</option>
                                    <option value="01">Jan</option>
                                    <option value="02">Feb</option>
                                    <option value="03">Mar</option>
                                    <option value="04">Apr</option>
                                    <option value="05">May</option>
                                    <option value="06">Jun</option>
                                    <option value="07">Jul</option>
                                    <option value="08" selected>Aug</option>
                                    <option value="09">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                                <select name="credit_card_year" class="select select-bordered flex-grow">
                                    <option disabled selected>Year</option>
                                    <option value="23">2023</option>
                                    <option value="24">2024</option>
                                    <option value="25" selected>2025</option>
                                    <option value="26">2026</option>
                                    <option value="27">2027</option>
                                    <option value="28">2028</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text"></span>
                            </label>
                            <input name="credit_card_cvc" value="123" type="text" placeholder="Enter your cvc." class="input input-bordered w-full @error('credit_card_cvc') input-error @enderror" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text"></span>
                            </label>
                            <label class="label cursor-pointer">
                                <span class="label-text">Remember my card:</span>
                                <input type="checkbox" value="on" name="remember_card" class="toggle" id="is_direct_post" />
                            </label>
                        </div>
                    </div>
                    <button class="btn" type="submit">Pay</button>
                </form>
            </div>
            <div class="flex-1 min-h-12 card bg-base-100 shadow-md">
                <div class="flex flex-col space-y-4 p-4 sm:p-8">
                    <h3 class="text-2xl font-bold">Order List</h3>
                    <ul class="bg-base-200 dark:bg-base-300 border border-gray-300 dark:border-gray-500 rounded-lg divide-y divide-gray-300 dark:divide-gray-500">
                        @if($orders->count() > 0)
                        @foreach($orders as $order)
                        <li class="min-h-12 p-4 flex flex-col">
                            <h3 class="text-md font-semibold">Txn ID: {{$order->txn_id}}</h3>
                            <p class="text-sm">{{$order->product_name}}</p>
                            <p class="text-sm">RM {{$order->product_price/100}}</p>
                            @if($order->status == 'purchase.paid' || $order->status == 'paid')
                            <div class="badge badge-success">{{$order->status}}</div>
                            @elseif($order->status !== 'purchase.payment_failure')
                            <div class="badge badge-error">{{$order->status}}</div>
                            @else
                            <div class="badge badge-warning">{{$order->status}}</div>
                            @endif
                        </li>
                        @endforeach

                        @if($orders->total() > 4)
                        <li class="min-h-12 p-2 text-center">
                            <p class="text-subtitle">{{$orders->total() - 4}} more...</p>
                        </li>
                        @endif

                        @else
                        <li class="min-h-12 p-4 text-center">
                            <p class="text-sm">No data</p>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    let isDirectPost = false
    document.getElementById('is_direct_post').addEventListener('change', function(evt) {
        if (isDirectPost) {
            document.getElementById('credit_card_form').classList.add('hidden')
        } else {
            document.getElementById('credit_card_form').classList.remove('hidden')
        }
        isDirectPost = !isDirectPost
    })
</script>

</html>