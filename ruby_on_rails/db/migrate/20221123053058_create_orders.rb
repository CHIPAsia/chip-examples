class CreateOrders < ActiveRecord::Migration[7.0]
  def change
    create_table :orders do |t|
      t.string :product_name
      t.integer :product_price
      t.string :customer_email
      t.string :txn_id, null: true
      t.string :status, default: 'pending'

      t.timestamps
    end
  end
end
