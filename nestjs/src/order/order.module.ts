import { Module } from "@nestjs/common";
import { OrderService } from "./service/order.service";
import { TypeOrmModule } from "@nestjs/typeorm";
import { OrderEntity } from "./order.entity";

@Module({
  imports: [TypeOrmModule.forFeature([OrderEntity])],
  providers: [OrderService],
})
export class OrderModule {}
