<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/laravel-v9.19-blue"/>
<img src="https://img.shields.io/badge/license-MIT-green"/>
</p>

---

## Notes

### This sample app is built on top of `Docker`. Thus your are required to install it before running the app. Refer [here](https://laravel.com/docs/9.x/installation#getting-started-on-macos) for more details.

### Make sure in your `.env` file containing the following key & value:

- BASE_URL_FOR_WEBHOOK="[Your url for listening to event from payment webhook. i.e. https://your-domain.com/api/webhook/payment]"
- CHIP_BRAND_ID="[Your Brand ID that you can obtain in the Developers section in your account]"
- CHIP_API_KEY="[Your API key that you can obtain in the Developers section in your account]"
- CHIP_ENDPOINT="https://gate.chip-in.asia/api/v1/"
- CHIP_PUBLIC_KEY_FOR_WEBHOOK="[Public key for webhook. You can obtain the public key for `Webhook` authentication from `Webhook.public_key` of the corresponding `Webhook`]"

### Execute the following to run the app:

1. Make sure to install all dependencies:

   ```bash
   composer dump-autoload    //remove autoload

   composer install          //install dependencies

   yarn                      //install style dependencies
   ```

1. Next, run the following to start the app:

   ```bash
   ./vendor/bin/sail up
   ```

   The app will be running at http://localhost:80.

1. On new terminal, run:

   ```bash
   yarn dev
   ```

   This will run asset bundler ([Vite](https://laravel.com/docs/9.x/vite)).

1. Run below to migrate DB:
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

---

## Laravel - Chip Integration

1. Add the following into `composer.json`, after `license` line:
   ```php
   ...
    "repositories": [
      {
          "type": "vcs",
          "url": "git@github.com:CHIPAsia/chip-php-sdk.git"
      }
    ],
   ...
   ```
1. Run the following to install the library & it's dependency:

   ```bash
   composer require chip/chip-sdk-php

   composer require netresearch/jsonmapper
   ```

1. Make sure use correct `brand_id`, `api_key` & `endpoint`. Remember to terminate the `endpoint` with a forward slash `/`. [Reference](https://stackoverflow.com/a/30874624)

1. Refer [this](https://gate.chip-in.asia/apis/libraries/PHP) link, for more details.
