Rails.application.routes.draw do
  # Define your application routes per the DSL in https://guides.rubyonrails.org/routing.html

  # Defines the root path route ("/")
  # root "articles#index"

  get '/', to: 'payment#index'
  get '/cc_form', to: 'payment#cc_form'
  post '/payment', to: 'payment#create'

  post '/api/callback/payment-success', to: 'payment#callbackPaymentSuccess'
  post '/api/webhook/payment', to: 'payment#webhookPayment'
end
