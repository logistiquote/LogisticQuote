<?php

namespace App\Console\Commands;

use App\Enums\QuotationStatus;
use App\Models\Quotation;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateQuotationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotations:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update quotation statuses based on expiration date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $updatedRows = Quotation::whereIn('status', [QuotationStatus::ACTIVE, QuotationStatus::PENDING_PAYMENT])
            ->where('created_at', '<=', Carbon::now()->subDays(14))
            ->update(['status' => QuotationStatus::EXPIRED]);

        $this->info("Updated $updatedRows quotations to expired status.");
    }
}
