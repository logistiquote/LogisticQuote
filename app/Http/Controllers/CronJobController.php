<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Carbon\Carbon;

class CronJobController extends Controller
{
    public function index()
    {
        $quotations = Quotation::where('status', '!=', 'done')->get();
        $now = Carbon::now();
        foreach($quotations as $quotation)
        {
            // If it is weekend
            $weekMap = [
                0 => 'SU',
                1 => 'MO',
                2 => 'TU',
                3 => 'WE',
                4 => 'TH',
                5 => 'FR',
                6 => 'SA',
            ];

            if($quotation->created_at->dayOfWeek == 4)
            {
                $expire = $quotation->created_at->addDays(4);
            }
            else if($quotation->created_at->dayOfWeek == 5)
            {
                $expire = $quotation->created_at->addDays(3)->endOfDay();
            }
            else if($quotation->created_at->dayOfWeek == 6)
            {
                $expire = $quotation->created_at->addDays(2)->endOfDay();
            }
            else if($quotation->created_at->dayOfWeek == 0)
            {
                $expire = $quotation->created_at->addDays(1)->endOfDay();
            }
            else
            {
                $expire = $quotation->created_at->addHours(24);
            }

            // Check expiration
            if($now > $expire)
            {
                $quotation->status = 'done';
                $quotation->save();
            }
        }
    }
}
