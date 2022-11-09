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
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
            <div class="flex-1 min-h-12 card bg-base-100 shadow-md">
                <form method="POST" action="/payment" class="flex flex-col space-y-4 p-4 sm:p-8">
                    <h3 class="text-2xl font-bold">Order Form</h3>
                    @csrf
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Product Name</span>
                        </label>
                        <input name="product_name" value="{{$product->title}}" type="text" placeholder="Your name" class="input input-bordered w-full" />
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Amount (RM)</span>
                        </label>
                        <input name="product_price" type="number" value="{{$product->price}}" class="input input-bordered w-full" />
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Your Email</span>
                        </label>
                        <input name="client_email" value="{{fake('ms_MY')->unique()->safeEmail()}}" type="email" placeholder="Your email" class="input input-bordered w-full" />
                    </div>
                    <button class="btn" type="submit">Pay</button>
                </form>
            </div>
            <div class="flex-1 min-h-12 card bg-base-100 shadow-md">
                <div class="flex flex-col space-y-4 p-4 sm:p-8">
                    <h3 class="text-2xl font-bold">Order List</h3>
                    <ul class="bg-base-200 dark:bg-base-300 border border-gray-300 dark:border-gray-500 rounded-lg divide-y divide-gray-300 dark:divide-gray-500">
                        <li class="min-h-12 p-4 flex flex-col">
                            <h3 class="text-md font-semibold">Txn ID</h3>
                            <p class="text-sm">product_name</p>
                            <p class="text-sm">product_price</p>
                            <div class="badge badge-success">Paid</div>
                        </li>
                        <li class="min-h-12 p-4 flex flex-col">
                            <h3 class="text-md font-semibold">Txn ID</h3>
                            <p class="text-sm">product_name</p>
                            <p class="text-sm">product_price</p>
                            <div class="badge badge-error">Fail</div>
                            <button class="btn btn-xs mt-5">Pay Again</button>
                        </li>
                        <li class="min-h-12 p-4 flex flex-col">
                            <h3 class="text-md font-semibold">Txn ID</h3>
                            <p class="text-sm">product_name</p>
                            <p class="text-sm">product_price</p>
                            <div class="badge badge-error">Fail</div>
                            <button class="btn btn-xs mt-5">Pay Again</button>
                        </li>
                        <li class="min-h-12 p-2 text-center">
                            <p class="text-subtitle">43 more...</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>