<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationImportRequest;
use App\Services\LocationImportService;
use Exception;

class ImportController extends Controller
{
    public function __construct(protected LocationImportService $importService)
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * @throws Exception
     */
    public function importLocations(LocationImportRequest $request)
    {
        $validatedData = $request->validated();

        $filePath = $request->file('file')->getRealPath();
        $type = $request->get('type');

        $this->importService->setStrategy($type);

        $results = $this->importService->import($filePath);

        return redirect()->route('location.index')
            ->with('success', 'File imported successfully!');
    }
}
