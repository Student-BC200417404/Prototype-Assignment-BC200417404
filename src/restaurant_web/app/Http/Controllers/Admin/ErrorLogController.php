<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ErrorLogController extends Controller
{
    /**
     * Log error from client-side
     */
    public function logClientError(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:500',
                'context' => 'nullable|string',
                'url' => 'nullable|url',
                'user_agent' => 'nullable|string'
            ]);

            ErrorLog::create([
                'message' => $request->message,
                'context' => $request->context,
                'url' => $request->url,
                'user_agent' => $request->user_agent,
                'user_id' => auth()->id(),
                'ip_address' => $request->ip(),
                'level' => 'error',
                'stack_trace' => null
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Failed to log client error: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Display error logs
     */
    public function index()
    {
        try {
            $errorLogs = ErrorLog::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return view('admin.pages.errorlog.index', compact('errorLogs'));
        } catch (\Exception $e) {
            Log::error('Failed to load error logs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load error logs.');
        }
    }

    /**
     * Show error log details
     */
    public function show($id)
    {
        try {
            $errorLog = ErrorLog::with('user')->findOrFail($id);
            return view('admin.pages.errorlog.show', compact('errorLog'));
        } catch (\Exception $e) {
            return redirect()->route('admin.error-logs.index')
                ->with('error', 'Error log not found.');
        }
    }

    /**
     * Clear old error logs
     */
    public function clearOld(Request $request)
    {
        try {
            $days = $request->input('days', 30);
            $deleted = ErrorLog::where('created_at', '<', now()->subDays($days))->delete();

            return response()->json([
                'success' => true,
                'message' => "Cleared {$deleted} error logs older than {$days} days."
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to clear error logs: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear error logs.'
            ], 500);
        }
    }

    /**
     * Export error logs
     */
    public function export(Request $request)
    {
        try {
            $format = $request->input('format', 'csv');
            $days = $request->input('days', 30);

            $errorLogs = ErrorLog::with('user')
                ->where('created_at', '>=', now()->subDays($days))
                ->orderBy('created_at', 'desc')
                ->get();

            if ($format === 'csv') {
                return $this->exportToCsv($errorLogs);
            } else {
                return $this->exportToJson($errorLogs);
            }
        } catch (\Exception $e) {
            Log::error('Failed to export error logs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to export error logs.');
        }
    }

    /**
     * Export to CSV
     */
    private function exportToCsv($errorLogs)
    {
        $filename = 'error_logs_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($errorLogs) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID', 'Message', 'Level', 'URL', 'User', 'IP Address', 'Created At'
            ]);

            // Add data
            foreach ($errorLogs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->message,
                    $log->level,
                    $log->url,
                    $log->user ? $log->user->name : 'Guest',
                    $log->ip_address,
                    $log->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export to JSON
     */
    private function exportToJson($errorLogs)
    {
        $filename = 'error_logs_' . date('Y-m-d_H-i-s') . '.json';
        
        $data = $errorLogs->map(function ($log) {
            return [
                'id' => $log->id,
                'message' => $log->message,
                'level' => $log->level,
                'url' => $log->url,
                'user' => $log->user ? $log->user->name : 'Guest',
                'ip_address' => $log->ip_address,
                'created_at' => $log->created_at->toISOString()
            ];
        });

        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
} 