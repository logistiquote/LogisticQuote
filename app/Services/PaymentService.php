<?php

namespace App\Services;

use App\Models\Quotation;
use App\Repositories\PaymentRepository;
use App\Services\Payment\PaymentFactory;
use Exception;

class PaymentService
{
    public function __construct(private PaymentRepository $paymentRepository)
    {
    }

    /**
     * @throws Exception
     */
    public function processPayment(string $provider, Quotation $quotation, array $data): string
    {

        try {
            $payment = PaymentFactory::create($provider);

            $orderId = $payment->initialize($data);
            $this->paymentRepository->saveTransaction([
                'provider' => $provider,
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'USD',
                'status' => 'PENDING',
                'order_id' => $orderId,
                'transaction_id' => $data['transaction_id'] ?? null,
                'metadata' => $data['metadata'] ?? [],
                'quotation_id' => $quotation->id,
            ]);
            return $payment->confirm();
        } catch (Exception $ex) {
            throw new Exception("Payment failed for provider. " . $ex->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function executePayment(string $provider, string $orderId): string
    {
        try {
            $payment = PaymentFactory::create($provider);

            return $payment->execute($orderId);
        } catch (Exception $ex) {
            throw new Exception("Payment failed for provider. " . $ex->getMessage());

        }
    }
}

