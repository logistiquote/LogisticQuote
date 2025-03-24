<?php

namespace App\Observers;

use App\Models\Quotation;
use App\Models\User;
use App\Services\NotificationService;

class QuotationObserver
{
    public function __construct(protected NotificationService $notificationService) {
    }
    /**
     * Handle the Quotation "created" event.
     */
    public function created(Quotation $quotation): void
    {
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $this->notificationService->createNotification(
                $admin->id,
                "A new quotation #{$quotation->id} has been created by {$quotation->user->name}",
                $quotation->id
            );

            $hasZeroPriceContainer = $quotation->containers()
                ->where('price_per_container', 0)
                ->exists();
            if ($hasZeroPriceContainer) {
                $this->notificationService->createNotification(
                    $admin->id,
                    "Custom Pricing Needed! Quotation #{$quotation->id} requires a custom price",
                    $quotation->id
                );
            }
        }


    }

    public function updating(Quotation $quotation): void
    {
        if ($quotation->isDirty('status')) {
            $this->notificationService->createNotification(
                $quotation->user_id,
                "Your quotation #{$quotation->id} status has been updated to {$quotation->status}.",
                $quotation->id
            );
        }
    }

    /**
     * Handle the Quotation "updated" event.
     */
    public function updated(Quotation $quotation): void
    {

    }

    /**
     * Handle the Quotation "deleted" event.
     */
    public function deleted(Quotation $quotation): void
    {
        //
    }

    /**
     * Handle the Quotation "restored" event.
     */
    public function restored(Quotation $quotation): void
    {
        //
    }

    /**
     * Handle the Quotation "force deleted" event.
     */
    public function forceDeleted(Quotation $quotation): void
    {
        //
    }
}
