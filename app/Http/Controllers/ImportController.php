<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationImportRequest;
use App\Services\LocationImportService;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    public function __construct(protected LocationImportService $importService)
    {
    }

    public function importLocations(LocationImportRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $filePath = $request->file('file')->getRealPath();

            $this->importService->setStrategy($validatedData['type']);

            $this->importService->import($filePath);

            return redirect()->route('location.index')
                ->with('success', 'File imported successfully!');
        } catch (\Exception $e) {
            Log::error('ImportController(importLocations). Error: '.$e->getMessage());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
