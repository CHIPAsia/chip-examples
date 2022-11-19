import {
  Controller,
  Get,
  Post,
  Render,
  Res,
  HttpStatus,
  Req,
  Query,
  HttpException,
  RawBodyRequest,
} from "@nestjs/common";
import { PRODUCTS } from "../constants/index";
import { Request, Response } from "express";
import { OrderService } from "./order/service/order.service";
import { default as Chip } from "Chip";
@Controller()
export class AppController {
  constructor(private orderService: OrderService) {}

  @Get()
  @Render("index")
  async root(@Query() query): Promise<any> {
    const product = PRODUCTS[Math.floor(Math.random() * PRODUCTS.length)];

    // get order from db
    const orders = await this.orderService.order();

    return {
      isSuccess: query["status"] === "success",
      isFail: query["status"] === "fail",
      form: {
        title: product.title,
        email: "gegurl@gmail.com",
        price: product.price,
      },
      orders: {
        data: orders.slice(0, 4).map((order) => {
          return {
            ...order,
            product_price: order.product_price / 100,
            isPaid: ["purchase.paid", "paid"].includes(order.status),
            isFailPay: ["purchase.payment_failure", "error"].includes(
              order.status
            ),
          };
        }),
        metadata: { total: orders.length, moreThan4: orders.length > 4 },
      },
    };
  }

  @Post("/payment")
  async payment(@Req() req: Request, @Res() res: Response) {
    const inputs = req.body;

    const price_in_cent = parseFloat(inputs["product_price"]) * 100;

    // create order
    const order = await this.orderService.createOrder({
      product_name: inputs["product_name"],
      product_price: price_in_cent,
      customer_email: inputs["client_email"],
    });

    // setup api payload
    Chip.ApiClient.instance.basePath = process.env.CHIP_ENDPOINT;
    Chip.ApiClient.instance.token = process.env.CHIP_API_KEY;
    const apiInstance = new Chip.PaymentApi();

    let apiCallback = async (error, data, response) => {
      if (error) {
        console.log("API call failed. Error:");
        console.error(error);
        res.redirect("http://localhost:3000?status=fail");
      } else {
        // extract & save transaction id from checkout_url
        await this.orderService.updateOrderTxnId(order.id, data.id);
        // redirect to payment gateway
        res.redirect(data.checkout_url);
      }
    };

    const client = new Chip.ClientDetails(order.customer_email);
    const product = new Chip.Product(order.product_name, order.product_price);
    const details = new Chip.PurchaseDetails([product]);
    const purchase = new Chip.Purchase();
    purchase.success_redirect = "http://localhost:3000?status=success";
    purchase.failure_redirect = "http://localhost:3000?status=fail";
    purchase.success_callback = `${process.env.BASE_URL_FOR_WEBHOOK}/api/callback/payment-success`;
    purchase.brand_id = process.env.CHIP_BRAND_ID;
    purchase.client = client;
    purchase.purchase = details;
    apiInstance.purchasesCreate(purchase, apiCallback);
  }
}

@Controller()
export class CallbackController {
  constructor(private orderService: OrderService) {}

  @Post("/api/callback/payment-success")
  async paymentSuccess(
    @Req() req: RawBodyRequest<Request>,
    @Res() res: Response
  ) {
    let signature: string;
    let content: any;
    let pub_key: string;

    const apiInstance = new Chip.PaymentApi();

    try {
      signature = req.get("X-Signature");
      content = req.rawBody;
    } catch (error) {
      throw new HttpException(error.message, 400);
    }

    const fetcher = await fetch(
      "https://gate.chip-in.asia/api/v1/public_key/",
      {
        headers: {
          Authorization: `Bearer ${process.env.CHIP_API_KEY}`,
        },
      }
    ).then((res) => res.json());
    pub_key = await fetcher.toString();

    const is_verified = apiInstance.verify(
      content,
      Buffer.from(signature, "base64"),
      pub_key
    );

    if (!is_verified) {
      console.log("CALLBACK: X-Signature Mismatch");
      throw new HttpException("X-Signature Mismatch", 400);
    }

    console.log("CALLBACK: X-Signature Ok!");
    this.orderService.updateOrderStatus(req.body.id, req.body.status);
    res.status(HttpStatus.OK).json({
      message: "CALLBACK OK!",
    });
  }
}

@Controller()
export class WebhookController {
  constructor(private orderService: OrderService) {}

  @Post("/api/webhook/payment")
  paymentSuccess(@Req() req: RawBodyRequest<Request>, @Res() res: Response) {
    let signature: string;
    let content: any;
    const pub_key = process.env.CHIP_PUBLIC_KEY_FOR_WEBHOOK;
    const apiInstance = new Chip.PaymentApi();

    try {
      signature = req.get("X-Signature");
      content = req.rawBody;
    } catch (error) {
      throw new HttpException(error.message, 400);
    }

    const is_verified = apiInstance.verify(
      content,
      Buffer.from(signature, "base64"),
      pub_key
    );

    if (!is_verified) {
      console.log("CALLBACK: X-Signature Mismatch");
      throw new HttpException("X-Signature Mismatch", 400);
    }

    console.log("WEBHOOK: X-Signature Ok!");
    this.orderService.updateOrderStatus(req.body.id, req.body.event_type);
    res.status(HttpStatus.OK).json({
      message: "WEBHOOK OK!",
    });
  }
}
