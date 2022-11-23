class Chip::Models::PaymentDetail
	attr_accessor :is_outgoing
	attr_accessor :payment_type
	attr_accessor :amount
	attr_accessor :currency
	attr_accessor :net_amount
	attr_accessor :fee_amount
	attr_accessor :pending_amount
	attr_accessor :pending_unfreeze_on
	attr_accessor :description
	attr_accessor :paid_on
	attr_accessor :remote_paid_on
end
