<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function exportUsers(Request $request):  BinaryFileResponse
    {
        $filters = $request->only(['name', 'email', 'role', 'date_from', 'date_to']);
        return Excel::download(new UsersExport($filters), 'users.xlsx');
    }
}
