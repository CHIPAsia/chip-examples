# CHIP for Minisite

Integrate CHIP with your Minisite written with HTML + PHP.

## Minimum system requirements

- PHP 7.4 or newer

## Installation

- [Download this Repository](https://github.com/CHIPAsia/chip-examples).
- Extract the downloaded archive.
- Navigate to **minisite** directory.
- Copy **src** folder to your minisite directory.

## Configuration

- Navigate to **src** directory.
- Edit **configuration.php** file:

- 'APIKEY' => 'Your API Key here'
- 'COLLECTION' => 'Your Collection ID here'
- 'X_SIGNATURE' => 'Your X Signature Key here'
- Change `$is_sandbox = false` to `$is_sandbox = true` for sandbox
- 'http://www.google.com' => 'The full URL to your minisite or the full URL to this script subdirectory.
- 'http://www.google.com/success.html' => 'The full URL to redirect your payee after successful payment'.
- **Optional**: Set $fallbackurl value  in the event of failure to redirect user to payment page
- **Optional**: Set $amount value for fixed payment value. Useful to avoid user setting their own price

---

For integration with Affiliate Pro software: **(Optional)**

  1. Include the tracking code in file **billplzpost.php** replacing

  `// Include tracking code here` with

  ```php
  include('affiliate-pro/controller/affiliate-tracking.php');
  ```
  
  2. Include the tracking code in file **redirect.php** replacing

  `// Include tracking code here` with

  ```php  
  $sale_amount = number_format((float)($rbody['amount']/100), 2, '.', '');
  $product = $rbody['description'];
  include('affiliate-pro/controller/record-sale.php');
  ```
  
  3. Insert the code below in **configuration.php**. Replace '30' with your own value
  
  ```php
  $commission = '30';
  ```
  
---

## How to use

You need to have a form which collect and pass the input to the script.

- Information that you can collect from using the HTML Form

  1. Payer Name => **Mandatory**
  1. Payer Email => **Mandatory** if (3) is not set
  1. Payer Mobile Phone Number => **Mandatory** if (2) is not set
  1. Amount => **Mandatory** if `$amount` value is not defined in `configuration.php`
  1. Reference 1 Label => Optional
  1. Reference 1 Data => Optional
  1. Reference 2 Label => Optional
  1. Reference 2 Data => Optional
  1. Payment Description => **Mandatory** if `$description` value is not defined in `configuration.php`
  1. Collection ID => **Mandatory** if `$collection_id` value is not defined in `configuration.php`
  
- The HTML Form input name must be according to the name below:

  1. Payer Name => **name**
  1. Payer Email => **email**
  1. Payer Mobile Phone Number => mobile
  1. Amount => **amount**
  1. Reference 1 Label => reference_1_label
  1. Reference 1 Data => reference_1
  1. Reference 2 Label => reference_2_label
  1. Reference 2 Data => reference_2
  1. Payment Description => **description**
  1. Collection ID => collection_id

## Form Example

- Please refer to index.php file

## Issues?

Facebook: [Billplz Dev Jam](https://www.facebook.com/groups/billplzdevjam/)
