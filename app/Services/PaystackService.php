<?php

namespace App\Services;

class PaystackService
{
    protected $secretKey;
    protected $baseUrl = 'https://api.paystack.co';

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key');
    }

    /**
     * Initialize a payment transaction
     */
    public function initializeTransaction($email, $amount, $reference = null, $metadata = [])
    {
        try {
            $data = [
                'email' => $email,
                'amount' => $amount * 100, // Convert to pesewas (kobo)
                'reference' => $reference ?? $this->generateReference(),
                'currency' => 'GHS',
                'metadata' => $metadata,
                'callback_url' => route('payment.callback'),
            ];

            $response = $this->makeRequest('/transaction/initialize', $data);

            if ($response['status']) {
                return [
                    'status' => true,
                    'authorization_url' => $response['data']['authorization_url'],
                    'access_code' => $response['data']['access_code'],
                    'reference' => $response['data']['reference'],
                ];
            }

            return [
                'status' => false,
                'message' => $response['message'] ?? 'Transaction initialization failed',
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify a transaction
     */
    public function verifyTransaction($reference)
    {
        try {
            $response = $this->makeRequest('/transaction/verify/' . $reference, null, 'GET');

            if ($response['status'] && $response['data']['status'] === 'success') {
                return [
                    'status' => true,
                    'data' => [
                        'reference' => $response['data']['reference'],
                        'amount' => $response['data']['amount'] / 100, // Convert back to GHS
                        'currency' => $response['data']['currency'],
                        'paid_at' => $response['data']['paid_at'],
                        'customer' => [
                            'email' => $response['data']['customer']['email'],
                            'customer_code' => $response['data']['customer']['customer_code'],
                        ],
                        'metadata' => $response['data']['metadata'] ?? [],
                    ],
                ];
            }

            return [
                'status' => false,
                'message' => 'Payment verification failed',
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Make HTTP request using cURL
     */
    private function makeRequest($endpoint, $data = null, $method = 'POST')
    {
        $url = $this->baseUrl . $endpoint;
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->secretKey,
            'Content-Type: application/json',
            'Cache-Control: no-cache',
        ]);

        if ($method === 'POST' && $data) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        // Timeout settings
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception('cURL Error: ' . $error);
        }
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new \Exception('HTTP Error: ' . $httpCode . ' - ' . $response);
        }

        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON decode error: ' . json_last_error_msg());
        }

        return $result;
    }

    /**
     * Generate a unique transaction reference
     */
    public function generateReference()
    {
        return 'PAY_' . time() . '_' . uniqid();
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhookSignature($input, $signature)
    {
        return $signature === hash_hmac('sha512', $input, $this->secretKey);
    }
}
