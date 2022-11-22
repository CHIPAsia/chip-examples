<p align="center"><a href="http://nestjs.com" target="_blank"><img src="https://nestjs.com/img/logo-small.svg" width="120" alt="NestJS Logo"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/nest-v9.0.1-blue"/>
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

1. Make sure to install all dependencies:

   ```bash
   yarn
   ```

1. Next, run the following to start the app:

   ```bash
   yarn start:dev
   ```

   The app will be running at http://localhost:3000.

1. On new terminal, run:
   ```
   npx tailwindcss -i ./src/input.css -o ./public/output.css --watch
   ```
   This will allow tailwindcss to listen to any changes on html classes & styles being made and update the `output.css` file accordingly.

---

## NestJS - Chip Integration

1. Run:

   ```bash
   yarn add https://gate.chip-in.asia/api_sdks/nodejs/
   ```

1. Make sure use `rawBody` to do verification on `X-Signature`. NestJS doesn't enable this option by default. Refer [here](https://docs.nestjs.com/faq/raw-body) for more details.

1. Refer [this](https://gate.chip-in.asia/apis/libraries/Node.js) link, for more details.
