<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Resident;
use App\Models\Purok;
use App\Models\Household;
use App\Models\Business;
use App\Models\Committee;
use App\Models\Document;
use App\Models\Blotter;
use App\Models\BlotterParty;
use App\Models\BlotterAttachment;
use App\Models\Official;
use Illuminate\Support\Str;


class BarangayController extends Controller
{ 

    // ── REPORTS ───────────────────────────────────────────────────────────────
    public function reports()
    {
        $totalResidents = Resident::count();
        $maleCount      = Resident::where('sex', 'Male')->count();
        $femaleCount    = Resident::where('sex', 'Female')->count();
        $voters         = Resident::where('is_voter', 1)->count();
        $nonVoters      = $totalResidents - $voters;
        $minors         = Resident::where('age', '<', 18)->count();
        $adults         = Resident::whereBetween('age', [18, 59])->count();
        $seniors        = Resident::where('age', '>=', 60)->count();

        // Civil status breakdown
        $civilStatus = Resident::selectRaw('civil_status, count(*) as count')
            ->groupBy('civil_status')
            ->pluck('count', 'civil_status');

        // Status breakdown
        $statusBreakdown = Resident::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('reports', compact(
            'totalResidents', 'maleCount', 'femaleCount',
            'voters', 'nonVoters', 'minors', 'adults', 'seniors',
            'civilStatus', 'statusBreakdown'
        ));
    }

    public function users()
    {
        return view('users');
    }

    // ── TECHNICAL / BACKUP ────────────────────────────────────────────────────
    public function technical()
    {
        $backupPath = storage_path('app/backup/backup.sql');
        $lastBackup = file_exists($backupPath)
            ? date('F d, Y h:i A', filemtime($backupPath))
            : 'No backup yet';

        $systemInfo = [
            'laravel_version' => app()->version(),
            'php_version'     => PHP_VERSION,
            'database'        => 'MySQL (Localhost)',
            'last_backup'     => $lastBackup,
        ];

        return view('technical', compact('systemInfo'));
    }

    public function backupDatabase()
    {
        $db   = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $pass = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $backupDir  = storage_path('app/backup');
        $backupFile = $backupDir . '/backup.sql';

        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $command = "mysqldump --user={$user} --password={$pass} --host={$host} {$db} > {$backupFile}";
        exec($command, $output, $result);

        if ($result === 0) {
            return redirect()->route('technical.index')
                ->with('success', 'Backup created successfully.');
        }

        return redirect()->route('technical.index')
            ->with('error', 'Backup failed. Check your database credentials.');
    }

    public function downloadBackup()
    {
        $backupFile = storage_path('app/backup/backup.sql');

        if (!file_exists($backupFile)) {
            return redirect()->route('technical.index')
                ->with('error', 'No backup file found. Please create a backup first.');
        }

        return response()->download($backupFile, 'barangay_backup_' . date('Y-m-d') . '.sql');
    }

    public function restoreDatabase(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql,txt',
        ]);

        $db   = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $pass = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $file = $request->file('backup_file');
        $path = $file->store('restore_temp');
        $fullPath = storage_path('app/' . $path);

        $command = "mysql --user={$user} --password={$pass} --host={$host} {$db} < {$fullPath}";
        exec($command, $output, $result);

        Storage::delete($path);

        if ($result === 0) {
            return redirect()->route('technical.index')
                ->with('success', 'Database restored successfully.');
        }

        return redirect()->route('technical.index')
            ->with('error', 'Restore failed. Make sure the file is a valid SQL dump.');
    }
    // ── DASHBOARD ─────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $totalResidents = Resident::count();
        $maleCount      = Resident::where('sex', 'Male')->count();
        $femaleCount    = Resident::where('sex', 'Female')->count();
        $voters         = Resident::where('is_voter', 1)->count();
        $minors         = Resident::where('age', '<', 18)->count();
        $adults         = Resident::whereBetween('age', [18, 59])->count();
        $seniors        = Resident::where('age', '>=', 60)->count();

        return view('dashboard', compact(
            'totalResidents', 'maleCount', 'femaleCount',
            'voters', 'minors', 'adults', 'seniors'
        ));
    }
}
