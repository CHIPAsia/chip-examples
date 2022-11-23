class PaymentController < ApplicationController
  skip_before_action :verify_authenticity_token, only: [:callbackPaymentSuccess, :webhookPayment]
  before_action :signature_header_exist, only: [:callbackPaymentSuccess, :webhookPayment]

  def index
    @status = params[:status]

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
    record.product_price = permitted_params[:product_price].to_f * 100

    if record.save
      status = "success"
    else
      status = "fail"
    end

    # Make request to Chip
    client = Chip::Models::ClientDetail.new
    client.email = record.customer_email

    product = Chip::Models::Product.new
    product.name = record.product_name
    product.price = record.product_price

    details = Chip::Models::PurchaseDetail.new
    details.products = [product]

    purchase = Chip::Models::Purchase.new
    purchase.order_id = record.id
    purchase.client = client
    purchase.purchase = details
    purchase.brand_id = ENV['CHIP_BRAND_ID']
    purchase.success_redirect = "http://localhost:3000?status=success"
    purchase.failure_redirect = "http://localhost:3000?status=fail"
    purchase.success_callback = ENV['BASE_URL_FOR_WEBHOOK'] + "/api/callback/payment-success"

    result = ChipApiService.new(ENV['CHIP_BRAND_ID'], ENV['CHIP_API_KEY'], ENV['CHIP_ENDPOINT']).createPurchase(purchase)
    
    if result == nil
      redirect_to action: 'index', payment_status: "fail"
      return
    end

    record.txn_id = result["id"]
    record.save

    redirect_to result["checkout_url"], allow_other_host: true
  end

  def callbackPaymentSuccess
    publicKey = @api.getPublicKey
    verify_signature(publicKey)

    update_order_status
    render json: {"status" => "CALLBACK: OK"}, status: 200
  end

  def webhookPayment
    publicKey = ENV['CHIP_PUBLIC_KEY_FOR_WEBHOOK']
    verify_signature(publicKey)

    update_order_status
    render json: {"status" => "WEBHOOK: OK"}, status: 200
  end

  private

  def permitted_params
    params.permit(:product_name, :product_price, :customer_email)
  end
  
  def signature_header_exist
    headers = request.headers
    unless headers['X-Signature'].present?
      render json: {"error" => "X-Signature header missing"}, status: 400
    end
    @signature = headers['X-Signature']
    @api = ChipApiService.new(ENV['CHIP_BRAND_ID'], ENV['CHIP_API_KEY'], ENV['CHIP_ENDPOINT'])
  end

  def verify_signature(publicKey)
    verified = @api.verify(request.raw_post, @signature, publicKey)
    if !verified
      render json: {"error" => "X-Signature Mismatch"}, status: 400
      return
    end
  end

  def update_order_status
    record = Order.where(["txn_id = ?", request["id"]]).order(created_at: :desc).take!
    if !record.present?
      render json: {"error" => "Record for transaction ID: #{request["id"]} not found"}, status: 400
      return
    end
    record.status = request["status"]
    record.save
  end
end
