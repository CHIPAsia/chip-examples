class Order < ApplicationRecord
  validates :product_name, :product_price, :customer_email, presence: true
end
