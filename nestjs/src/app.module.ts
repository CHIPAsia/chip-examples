import { Module } from "@nestjs/common";
import {
  AppController,
  CallbackController,
  WebhookController,
} from "./app.controller";
import { OrderModule } from "./order/order.module";
import { TypeOrmModule } from "@nestjs/typeorm";
import { OrderService } from "./order/service/order.service";
import { OrderEntity } from "./order/order.entity";
import { ConfigModule } from "@nestjs/config";

@Module({
  imports: [
    ConfigModule.forRoot(),
    TypeOrmModule.forRoot({
      type: "sqlite",
      database: "chip_in_db",
      entities: [__dirname + "/**/*.entity{.ts,.js}"],
      synchronize: true,
    }),
    OrderModule,
    TypeOrmModule.forFeature([OrderEntity]),
  ],
  controllers: [AppController, CallbackController, WebhookController],
  providers: [OrderService],
})
export class AppModule {}
