require 'httparty'

body_params = {
    "client": {
        "full_name": "Ahmad",
        "email": "example@email.com"
    },
    "purchase": {
        "products": [
            {
                "name": "Order #1",
                "price": 100
            }
        ]
    },
    "brand_id": "brand_id"
}

HTTParty.post('https://gate.chip-in.asia/api/v1/purchases/', {headers: {'Content-Type': "application/json", Authorization: 'Bearer secret_key'},body: body_params.to_json})