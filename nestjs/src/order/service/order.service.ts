import { Injectable, NotFoundException } from "@nestjs/common";
import { OrderEntity } from "../order.entity";
import { Repository } from "typeorm";
import { InjectRepository } from "@nestjs/typeorm";

@Injectable()
export class OrderService {
  constructor(
    @InjectRepository(OrderEntity)
    private orderRepository: Repository<OrderEntity>
  ) {}

  async order(): Promise<OrderEntity[]> {
    return await this.orderRepository.find({ order: { createdDate: "DESC" } });
  }

  async createOrder(order: {
    product_name: string;
    product_price: number;
    customer_email: string;
  }): Promise<OrderEntity> {
    return await this.orderRepository.save(order);
  }

  async updateOrderTxnId(orderId: any, txnId: string): Promise<OrderEntity> {
    const order = await this.orderRepository.findOne({
      where: { id: orderId },
    });

    if (!order) {
      throw new NotFoundException();
    }
    order.txn_id = txnId;

    await this.orderRepository.update(orderId, order);

    return order;
  }

  async updateOrderStatus(txnId: any, status: string): Promise<OrderEntity> {
    const order = await this.orderRepository.findOne({
      where: { txn_id: txnId },
    });

    if (!order) {
      throw new NotFoundException();
    }
    order.status = status;

    await this.orderRepository.update(order.id, order);

    return order;
  }
}
