<?php

// DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // Add this import if you're using DB facade

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the count of records in the files table
        $fileCount = DB::table('files')->count();
        $zipCount = DB::table('archives')->count();
        $patientCount = DB::table('patients')->count();

        // Pass the count to the view
        return view('dashboard', compact(['fileCount', 'zipCount', 'patientCount']));
    }
}
