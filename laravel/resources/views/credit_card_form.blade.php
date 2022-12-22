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
    <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
      <div class="flex-1 min-h-12 card bg-base-100 shadow-md">
        <form method="POST" action="{{ session('direct_post_url') }}" class="flex flex-col space-y-4 p-4 sm:p-8">
          @csrf
          <h3 class="text-2xl font-bold">Credit Card Form</h3>
          <div class="form-control w-full">
            <input name="cardholder_name" value="Test Card" type="text" placeholder="Enter your credit card name. i.e: Ahmad Azuddin" class="input input-bordered w-full" />
          </div>
          <div class="form-control w-full">
            <input name="card_number" value="4444333322221111" type="text" placeholder="Enter your credit card number. i.e: 1212232334344545" class="input input-bordered w-full" />
          </div>
          <div class="flex flex-row gap-4">
            <div class="form-control w-full">
              <input name="expires" value="08/25" type="text" placeholder="Enter your credit card expiry date. i.e: 08/25" class="input input-bordered w-full" />
            </div>
            <div class="form-control w-full">
              <input name="cvc" value="123" type="text" placeholder="Enter your CVC." class="input input-bordered w-full" />
            </div>
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text"></span>
            </label>
            <label class="label cursor-pointer">
              <span class="label-text">Remember my card:</span>
              <input type="checkbox" value="on" name="remember_card" class="toggle" checked />
            </label>
          </div>
          <button class="btn" type="submit">Pay</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>