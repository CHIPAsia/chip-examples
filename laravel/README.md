<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

## Notes

#### This sample app is built on top of `Docker`. Thus your are required to install it before running the app. Refer [here](https://laravel.com/docs/9.x/installation#getting-started-on-macos) for more details.

#### Execute the following to run the app:

1. Make sure to install all dependencies

   ```bash
   composer dump-autoload   //remove autoload

   composer install         //install dependencies

   yarn                     //install style dependencies
   ```

1. Next

   ```bash
   ./vendor/bin/sail up     //start app
   ```

1. On new terminal, run
   ```bash
   yarn dev                 //run style hotreload
   ```

---

## Laravel - Chip Integration

1. Add the following into `composer.json`, after `license` line:
   ```php
   ...
   "repositories": [
     {
       "type": "package",
       "package": {
         "name": "chip/chip-sdk-php",
         "version": "1.0",
         "dist": {
           "url": "https://gate.chip-in.asia/api_sdks/php/",
           "type": "zip"
         },
         "autoload": {
           "classmap": [
             "lib/"
           ]
         }
       }
     }
   ],
   ...
   ```
1. Run:

   ```bash
   composer require chip/chip-sdk-php

   composer require netresearch/jsonmapper
   ```

1. Make sure use correct `brand_id`, `api_key` & `endpoint`. Remember to terminate the `endpoint` with a forward slash `/`. <sup>[[ref]](https://stackoverflow.com/a/30874624)</sup>

1. Follow [this](https://gate.chip-in.asia/apis/libraries/PHP), for more details.
