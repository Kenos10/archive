<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\File;

class ZipExtractController extends Controller
{
    public function extractAndListFiles(Request $request)
    {
        $request->validate([
            'zipFile' => 'required|file|mimes:zip',
            'password' => 'nullable|string',
        ]);

        $path = $request->file('zipFile')->store('zips');

        $zip = new ZipArchive;
        $fullPath = storage_path('app/' . $path);
        $password = $request->input('password');

        if ($zip->open($fullPath) === TRUE) {
            if ($password) {
                $zip->setPassword($password);
            }

            $extractPath = storage_path('app/extracted/' . basename($path, '.zip'));
            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0777, true);
            }

            $zip->extractTo($extractPath);
            $zip->close();

            // Delete the uploaded zip file after extraction
            Storage::delete($path);

            $files = array_diff(scandir($extractPath), array('.', '..'));

            $filepaths = [];
            foreach ($files as $file) {
                $filepaths[] = 'extracted/' . basename($path, '.zip') . '/' . $file;
            }

            return view('viewzip', ['filenames' => $filepaths]);
        } else {
            return back()->withErrors(['zipFile' => 'Failed to open the ZIP file.']);
        }
    }

    public function viewFile($filename)
    {
        $filePath = storage_path('app/' . $filename);

        if (file_exists($filePath)) {
            return response()->file($filePath);
        }

        abort(404);
    }

    public function deleteExtractedFolder()
    {
        $extractedPath = storage_path('app/extracted');
        if (File::exists($extractedPath)) {
            File::deleteDirectory($extractedPath);
        }
    }
}
