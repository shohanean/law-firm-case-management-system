<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    public function preview(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ]);

        $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray(null, true, true, true);

        if (empty($rows)) {
            return response()->json(['error' => 'The file is empty.'], 422);
        }

        // Find the header row (first row) and locate the Name column
        $headers   = array_map(fn($v) => strtolower(trim((string) $v)), $rows[1] ?? []);
        $nameCol   = array_search('name', $headers);

        if ($nameCol === false) {
            return response()->json(['error' => 'No "Name" column found in the file.'], 422);
        }

        // Collect non-empty names from data rows (skip header row 1)
        $names = [];
        foreach (array_slice($rows, 1, null, true) as $i => $row) {
            if ($i === 1) continue; // skip header
            $value = trim((string) ($row[$nameCol] ?? ''));
            if ($value !== '') {
                $names[] = $value;
            }
        }

        if (empty($names)) {
            return response()->json(['error' => 'No names found in the file.'], 422);
        }

        return response()->json(['names' => $names]);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'names'   => ['required', 'array', 'min:1'],
            'names.*' => ['required', 'string', 'max:255'],
        ]);

        $records = array_map(fn($name) => [
            'client_name' => $name,
            'added_by'    => auth()->id(),
            'created_at'  => now(),
        ], $request->names);

        LegalCase::insert($records);

        return response()->json(['inserted' => count($records)]);
    }
}
