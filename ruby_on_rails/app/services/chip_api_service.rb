class ChipApiService
  def initialize(brandId, apiKey, baseUrl)
    @brandId = brandId
    @apiKey = apiKey
    @baseUrl = baseUrl
  end

  def createPurchase(purchase)
    request
    response = @client.post('purchases/') do |req|
      req.body = purchase.to_json
    end

    if response.status < 400
      response.body
    else
      nil
    end
  end

  def getPublicKey
    request
    response = @client.get('public_key/')
    response.body
  end
  
  def verify(content, signature, publicKey)
    verification = OpenSSL::PKey::RSA.new(publicKey)
    base64_signature = Base64.decode64(signature)

    verification.verify(OpenSSL::Digest::SHA256.new, base64_signature, content)
  end

  private

  def request
    @client = Faraday.new(url: @baseUrl, headers: {'Authorization' => "Bearer #{@apiKey}"}) do |f|
      f.request :json # encode req bodies as JSON and automatically set the Content-Type header
      f.response :json # decode response bodies as JSON
    end
  end
end