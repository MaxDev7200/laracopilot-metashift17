<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function debug()
    {
        // Check database connection
        $dbConnected = false;
        try {
            DB::connection()->getPdo();
            $dbConnected = true;
        } catch (\Exception $e) {
            $dbConnected = false;
        }

        // Get table counts
        $tables = [];
        if ($dbConnected) {
            try {
                $tableNames = ['users', 'feature_flags', 'feature_environments', 'feature_user_overrides', 'cache', 'jobs', 'sessions'];
                foreach ($tableNames as $tableName) {
                    try {
                        $count = DB::table($tableName)->count();
                        $tables[$tableName] = $count;
                    } catch (\Exception $e) {
                        $tables[$tableName] = 'Error';
                    }
                }
            } catch (\Exception $e) {
                // Ignore
            }
        }

        // Get recent logs
        $logs = [];
        $logPath = storage_path('logs/laravel.log');
        if (File::exists($logPath)) {
            $logContent = File::get($logPath);
            $logLines = explode("\n", $logContent);
            $logs = array_slice(array_reverse($logLines), 0, 20);
            $logs = array_filter($logs);
        }

        return view('debug', compact('dbConnected', 'tables', 'logs'));
    }
}