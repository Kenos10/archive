<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileFormat;

class FileFormatController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'prefix' => 'required|string',
            'prefix_value' => 'nullable|string',
            'prefix_year_format' => 'nullable|in:full,short',
            'prefix_year_only' => 'boolean',
            'prefix_month_only' => 'boolean',
            'prefix_day_only' => 'boolean',
            'suffix' => 'nullable|string',
            'suffix_value' => 'nullable|string',
            'suffix_year_format' => 'nullable|in:full,short',
            'suffix_year_only' => 'boolean',
            'suffix_month_only' => 'boolean',
            'suffix_day_only' => 'boolean',
            'auto_number' => 'boolean',
            'starter_number' => 'nullable|integer|min:0',
            'include_hyphens' => 'boolean',
        ]);

        // Delete any existing records
        FileFormat::truncate();

        $created = FileFormat::create($request->all());

        return back()->with('success', 'Record created successfully');
    }
}
