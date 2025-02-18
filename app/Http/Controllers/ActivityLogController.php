<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        $data['activities'] = Activity::latest()->paginate(25);

        $data['page_name'] = 'activity_log';
        $data['page_title'] = 'Activity Logs | LogistiQuote';

        return view('panels.activity-logs.index', $data);
    }
}

