<?php

namespace App\Repositories;

use App\Models\Transaction;

class PaymentRepository
{
    public function saveTransaction(array $data)
    {
        Transaction::create($data);
    }

    public function getTransactionById(int $id): ?Transaction
    {
        return Transaction::findOrFail($id);
    }

    public function updateTransactionStatus(int $id, string $status): bool
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => $status]);
        return true;
    }
}
