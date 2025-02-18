<?php

namespace App\Services\Payment;

use App\Enums\QuotationStatus;
use App\Models\Quotation;
use App\Models\Transaction;
use Exception;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;

class PayPalPayment implements PaymentStrategy
{
    private $provider;
    private $approvalUrl;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->provider = new PayPalClient();
        $this->provider->setApiCredentials(config('paypal'));
    }

    /**
     * Initialize PayPal-specific setup.
     *
     * @param array $data
     * @throws Exception
     */
    public function initialize(array $data)
    {
        // Generate a new access token
        $paypalToken = $this->provider->getAccessToken();
        $this->provider->setAccessToken($paypalToken);

        // Create the order
        try {
            $response = $this->provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => $data['currency'] ?? 'USD',
                            "value" => $data['amount'],
                        ],
                        "description" => $data['description'] ?? 'Payment Description',
                    ],
                ],
                "application_context" => [
                    "return_url" => $data['return_url'],
                    "cancel_url" => $data['cancel_url'],
                ],
            ]);

            if (isset($response['id']) && $response['status'] === 'CREATED') {
                // Save the approval URL
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        $this->approvalUrl = $link['href'];
                        return $response['id'];
                    }
                }
            }

            throw new Exception('Could not retrieve PayPal approval URL.');
        } catch (Exception $ex) {
            throw new Exception("Error initializing PayPal payment: " . $ex->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function confirm(): string
    {
        if (!$this->approvalUrl) {
            throw new Exception("Approval URL not set. Call initialize() first.");
        }

        return $this->approvalUrl;
    }

    /**
     * Execute the payment after approval.
     *
     * @throws Throwable
     */
    public function execute(string $orderId): string
    {
        $paypalToken = $this->provider->getAccessToken();
        $this->provider->setAccessToken($paypalToken);

        // Capture the payment
        try {
            $response = $this->provider->capturePaymentOrder($orderId);

            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                $transaction = Transaction::where('order_id', $orderId)->firstOrFail();
                $transaction->update([
                    'status' => 'COMPLETED',
                    'transaction_id' => $response['id'],
                ]);
                Quotation::where('id', $transaction->quotation_id)->update([
                    'is_paid' => 1,
                    'status' => QuotationStatus::PAID,
                ]);
                return 'Payment successfully executed with transaction ID: ' . $response['id'];
            }

            throw new Exception('Payment not approved. Status: ' . $response['status']);
        } catch (Exception $ex) {
            Transaction::where('order_id', $orderId)->delete();
            throw new Exception("Error capturing PayPal payment: " . $ex->getMessage());
        }
    }
}
