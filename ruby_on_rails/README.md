<p align="center" style="background: #D30001;border-radius: 100%; width: 120px; height: 120px; display: flex; justify-content: center; margin: 1em auto;"><a href="https://rubyonrails.org" target="_blank"><img style="filter: brightness(0) invert(1); margin-top: 2.5em;" src="https://rubyonrails.org/assets/images/logo.svg" width="100"alt="Ruby on Rails Logo"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/rails-v7.0.4-blue"/>
<img src="https://img.shields.io/badge/license-MIT-green"/>
</p>

---

## Notes

### Make sure in your `.env` file containing the following key & value:

- BASE_URL_FOR_WEBHOOK="[Your url for listening to event from payment webhook. i.e. https://your-domain.com/api/webhook/payment]"
- CHIP_BRAND_ID="[Your Brand ID that you can obtain in the Developers section in your account]"
- CHIP_API_KEY="[Your API key that you can obtain in the Developers section in your account]"
- CHIP_ENDPOINT="https://gate.chip-in.asia/api/v1/"
- CHIP_PUBLIC_KEY_FOR_WEBHOOK="[Public key for webhook. You can obtain the public key for `Webhook` authentication from `Webhook.public_key` of the corresponding `Webhook`]"

### Execute the following to run the app:

1. This app was built by referring to this [tutorial](https://github.com/docker/awesome-compose/tree/master/official-documentation-samples/rails).

1. Start the app by running the following:

   ```bash
   docker compose build
   docker compose up
   ```

   The app will be running at http://localhost:3000.

1. If your DB hasn't created yet; On different terminal, run following to create DB:

   ```bash
   docker compose run web rake db:create
   ```

1. Press `ctrl` + `c` , Then run below to stop the container:

   ```bash
   docker compose down
   ```
