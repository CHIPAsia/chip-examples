class PaymentController < ApplicationController
  skip_before_action :verify_authenticity_token, only: [:create, :payment, :callbackPaymentSuccess, :webhookPayment]

  def index
    @status = params[:payment_status]

    product = Product.SAMPLE_PRODUCT[rand(1..19)]
    @form = {
      title: product[:title],
      email: "no-reply@chip-in.asia",
      price: product[:price],
    }

    @orders = Order
      .order("orders.created_at DESC")
      .page(params[:page] || 1)
      .per(params[:limit] || 4)

    @count = @orders.total_count
  end

  def create
    record = Order.new permitted_params

    if record.save
      status = "success"
    else
      status = "fail"
    end
    
    redirect_to action: 'index', payment_status: status
  end

  def callbackPaymentSuccess
  end

  def webhookPayment
  end

  private

  def permitted_params
    params.permit(:product_name, :product_price, :customer_email)
  end
end
