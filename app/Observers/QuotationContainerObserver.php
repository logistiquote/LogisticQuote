<?php

namespace App\Observers;

use App\Models\QuotationContainer;
use App\Services\NotificationService;

class QuotationContainerObserver
{
    public function __construct(protected NotificationService $notificationService) {
    }
    /**
     * Handle the Quotation "created" event.
     */
    public function created(QuotationContainer $quotationContainer): void
    {

            if ($quotationContainer->isDirty('price_per_container') && $quotationContainer->getOriginal('price_per_container') == 0 && $quotationContainer->price_per_container > 0) {
                $this->notificationService->createNotification(
                    $quotationContainer->quotation->user_id,
                    "A container({$quotationContainer->routeContainer->container_type}) in quotation #{$quotationContainer->quotation_id} had its price updated",
                    $quotationContainer->quotation_id
                );
            }
    }

    /**
     * Handle the Quotation "updated" event.
     */
    public function updated(QuotationContainer $quotation): void
    {

    }

    /**
     * Handle the Quotation "deleted" event.
     */
    public function deleted(QuotationContainer $quotation): void
    {
        //
    }

    /**
     * Handle the Quotation "restored" event.
     */
    public function restored(QuotationContainer $quotation): void
    {
        //
    }

    /**
     * Handle the Quotation "force deleted" event.
     */
    public function forceDeleted(QuotationContainer $quotation): void
    {
        //
    }
}
