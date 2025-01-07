<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Quotation;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function createPayment(PaymentRequest $request)
    {
        $validatedData = $request->validated();

        $quotation = Quotation::findOrFail($validatedData['quotation_id']);
        $data = [
            'amount' => $quotation->total_price,
            'currency' => $validatedData['currency'] ?? 'USD',
            'description' => "Payment for quotation {$validatedData['quotation_id']} using {$validatedData['provider']}",
            'return_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
        ];

        try {
            $approvalUrl = $this->paymentService->processPayment($validatedData['provider'], $quotation,$data);
            return redirect()->away($approvalUrl);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function executePayment(Request $request)
    {
        $provider = $request->input('provider', 'paypal');
        $orderId = $request->query('token');

        try {
            $result = $this->paymentService->executePayment($provider,$orderId);
            return redirect('quotation.index')->with('success', $result);
        } catch (\Exception $e) {
            return redirect('quotation.index')->with('error', $e->getMessage());
        }
    }

    public function cancelPayment()
    {
        return redirect('quotation.index');
    }
}

