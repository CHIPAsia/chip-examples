import {
  Entity,
  Column,
  PrimaryGeneratedColumn,
  CreateDateColumn,
  UpdateDateColumn,
} from "typeorm";

@Entity()
export class OrderEntity {
  @PrimaryGeneratedColumn("uuid")
  id: number;

  @Column()
  product_name: string;

  @Column()
  product_price: number;

  @Column()
  customer_email: string;

  @Column({ nullable: true })
  txn_id: string;

  @Column({ default: "pending" })
  status: string;

  @CreateDateColumn()
  createdDate: Date;

  @UpdateDateColumn()
  updatedDate: Date;
}
