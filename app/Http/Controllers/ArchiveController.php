<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use App\Models\File;
use App\Models\Patient;
use Illuminate\Support\Facades\Crypt;
use App\Models\Archive;
use App\Models\FtpSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $zips = Archive::where('hospitalRecordId', 'like', '%' . $search . '%')
            ->paginate(8);
        return view('zips', compact('zips'));
    }

    public function store(Request $request)
    {
        $selectedFiles = $request->input('files');

        if (!is_array($selectedFiles)) {
            return redirect()->back()->withInput()->withErrors(['error' => 'No files selected']);
        }

        $filesToZip = [];
        foreach ($selectedFiles as $fileId) {
            $file = File::findOrFail($fileId);
            $path = $file->file;
            $hospitalRecordId = $file->hospitalRecordId;

            $passwordZip = Patient::where('hospitalRecordId', $hospitalRecordId)->first();
            if (!$passwordZip) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Please set password']);
            }

            $password = decrypt($passwordZip->password);
            $path = str_replace('/storage/', '', $path);
            $absolutePath = storage_path('app/public/' . $path);

            // Decrypt the file content
            $encryptedContent = file_get_contents($absolutePath);
            $decryptedContent = Crypt::decrypt($encryptedContent);

            $filesToZip[] = ['content' => $decryptedContent, 'password' => $password, 'filename' => basename($absolutePath)];
        }

        if (empty($filesToZip)) {
            return redirect()->back()->withInput()->withErrors(['error' => 'No files selected.']);
        }

        $zip = new ZipArchive();
        $zipDirectory = public_path('storage/zip_files');
        if (!file_exists($zipDirectory)) {
            mkdir($zipDirectory, 0775, true);
        }
        // Using hospitalRecordId and current date for zip file name
        $zipFileName = $zipDirectory . '/' . $hospitalRecordId . '.zip';

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($filesToZip as $file) {
                $zip->addFromString($file['filename'], $file['content']);
                $zip->setEncryptionName($file['filename'], ZipArchive::EM_AES_256, $file['password']);
            }
            $zip->close();

            $archive = Archive::updateOrCreate(
                ['hospitalRecordId' => $hospitalRecordId],
                ['zip' => '/storage/zip_files/' . $hospitalRecordId . '.zip']
            );

            // Touch the model to update the timestamps
            $archive->touch();

            return redirect()->back()->with('success', 'Zip file created');
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create the zip file.']);
        }
    }

    public function download($id)
    {
        $file = Archive::where("id", $id)->firstOrFail();
        $path = $file->zip;

        // Convert public path to storage path
        $absolutePath = public_path($path);
        Log::info('Absolute Path for download: ' . $absolutePath);

        if (!file_exists($absolutePath)) {
            Log::error('File not found: ' . $absolutePath);
            return redirect()->back()->withErrors(['error' => 'File not found.']);
        }

        // Create a download response
        $response = response()->download($absolutePath, basename($path));

        // After download delete the file from storage and database
        $response->deleteFileAfterSend(true);

        // Delete file record from the database
        $file->delete();

        return $response;
    }

    public function downloadPath($id)
    {
        $file = Archive::where("id", $id)->firstOrFail();
        $path = $file->zip;

        // Convert public path to storage path
        $absolutePath = public_path($path);

        if (!file_exists($absolutePath)) {
            return redirect()->back()->withErrors(['error' => 'File not found.']);
        }

        // Retrieve FTP settings from the database
        $ftpSetting = FtpSetting::first();

        if (!$ftpSetting) {
            return redirect()->back()->withErrors(['error' => 'FTP settings not found.']);
        }

        // Upload the file to FTP server
        try {
            // Set the FTP configuration
            Config::set('filesystems.disks.ftp', [
                'driver' => 'ftp',
                'host' => $ftpSetting->ftp_host,
                'username' => $ftpSetting->ftp_username,
                'password' => $ftpSetting->ftp_password,
                'port' => $ftpSetting->ftp_port,
            ]);

            $ftpDisk = Storage::disk('ftp');
            $remotePath = basename($path); // Only use the filename

            $ftpDisk->put($remotePath, fopen($absolutePath, 'r+'));

            // Add a success message to the session
            return redirect()->back()->with('success', 'File archived successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to archive the file.']);
        }
    }


    public function updateFtpSettings(Request $request)
    {
        $request->validate([
            'ftp_host' => 'required|string',
            'ftp_username' => 'required|string',
            'ftp_password' => 'required|string',
            'ftp_port' => 'required|integer',
        ]);

        $ftpSetting = FtpSetting::first();

        if ($ftpSetting) {
            $ftpSetting->update($request->all());
        } else {
            FtpSetting::create($request->all());
        }

        return redirect()->back()->with('success', 'FTP settings updated successfully');
    }

    public function showFtpSettings()
    {
        $ftpSetting = FtpSetting::first();
        return view('settings', compact('ftpSetting'));
    }

    public function setting()
    {
        return view('setting');
    }
}
