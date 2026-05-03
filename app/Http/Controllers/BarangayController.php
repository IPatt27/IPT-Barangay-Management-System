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

    // DOCUMENT METHODS START

    // Index — show all issued documents in a DataTable
    public function documents()
    {
        return view('documents.index');
    }
    
    // Create — show the issue document form
    public function documentsCreate()
    {
        $residents = Resident::orderBy('last_name')->get();
        return view('documents.create', compact('residents'));
    }
    
    // Store — save the new document record
    public function documentsStore(Request $request)
    {
        $request->validate([
            'resident_id'   => 'required|exists:residents,id',
            'document_type' => 'required|string',
            'purpose'       => 'required|string|max:255',
            'or_number'     => 'nullable|string|max:100',
            'issued_by'     => 'required|string|max:255',
            'position'      => 'nullable|string|max:255',
        ]);
    
        $document = Document::create($request->all());
    
        // Redirect straight to the print view after issuing
        return redirect()->route('documents.print', $document->id)
                         ->with('success', 'Document issued successfully.');
    }
    
    // Print — show the print-ready certificate
    public function documentsPrint($id)
    {
        $document = Document::with('resident')->findOrFail($id);
        return view('documents.print', compact('document'));
    }
    
    // Delete — remove a document record
    public function documentsDelete($id)
    {
        Document::findOrFail($id)->delete();
        return redirect()->route('documents.index')
                         ->with('success', 'Document deleted.');
    }
    
    // Yajra DataTable — supply JSON data for the documents table
    public function getDocuments()
    {
        $documents = Document::with('resident')->select('documents.*');
    
        return DataTables::of($documents)
            ->addColumn('resident_name', function ($doc) {
                return $doc->resident->first_name . ' ' . $doc->resident->last_name;
            })
            ->addColumn('action', function ($doc) {
                return '
                    <a href="' . route('documents.print', $doc->id) . '"
                       class="btn btn-sm btn-success" target="_blank">
                       <i class="fa fa-print"></i> Print
                    </a>
                    <form action="' . route('documents.delete', $doc->id) . '"
                          method="POST" style="display:inline;"
                          onsubmit="return confirm(\'Delete this document?\')">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    // DOCUMENT METHODS END

    // BLOTTER METHODS START

    public function blotter()
    {
        return view('blotter.index');
    }

    public function blotterCreate()
    {
        $residents = Resident::orderBy('last_name')->get();
        return view('blotter.create', compact('residents'));
    }

    public function blotterStore(Request $request)
    {
        $request->validate([
            'incident_type'        => 'required|string|max:255',
            'incident_date'        => 'required|date',
            'incident_location'    => 'required|string|max:255',
            'incident_description' => 'required|string',
            'recorded_by'          => 'required|string|max:255',
            'status'               => 'required|string',
            'parties'              => 'required|array|min:1',
            'parties.*.name'       => 'required|string|max:255',
            'parties.*.role'       => 'required|in:Complainant,Respondent,Witness',
            'attachments.*'        => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);
    
        // Generate case number: BLT-YYYY-XXXXXX
        $year       = now()->year;
        $lastId     = Blotter::whereYear('created_at', $year)->count() + 1;
        $caseNumber = 'BLT-' . $year . '-' . str_pad($lastId, 6, '0', STR_PAD_LEFT);
    
        $blotter = Blotter::create([
            'case_number'          => $caseNumber,
            'incident_type'        => $request->incident_type,
            'incident_date'        => $request->incident_date,
            'incident_location'    => $request->incident_location,
            'incident_description' => $request->incident_description,
            'status'               => $request->status,
            'recorded_by'          => $request->recorded_by,
            'remarks'              => $request->remarks,
        ]);
    
        // Save involved parties
        foreach ($request->parties as $party) {
            BlotterParty::create([
                'blotter_id'  => $blotter->id,
                'resident_id' => $party['resident_id'] ?? null,
                'name'        => $party['name'],
                'address'     => $party['address'] ?? null,
                'contact'     => $party['contact'] ?? null,
                'role'        => $party['role'],
            ]);
        }
    
        // Save attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('blotter_attachments', 'public');
                BlotterAttachment::create([
                    'blotter_id' => $blotter->id,
                    'file_name'  => $file->getClientOriginalName(),
                    'file_path'  => $path,
                    'file_type'  => $file->getMimeType(),
                ]);
            }
        }
    
        return redirect()->route('blotter.view', $blotter->id)
                         ->with('success', 'Blotter entry recorded successfully.');
    }
    
    public function blotterView($id)
    {
        $blotter = Blotter::with(['parties', 'attachments'])->findOrFail($id);
        return view('blotter.view', compact('blotter'));
    }
    
    public function blotterEdit($id)
    {
        $blotter   = Blotter::with('parties')->findOrFail($id);
        $residents = Resident::orderBy('last_name')->get();
        return view('blotter.edit', compact('blotter', 'residents'));
    }
    
    public function blotterUpdate(Request $request, $id)
    {
        $request->validate([
            'incident_type'        => 'required|string|max:255',
            'incident_date'        => 'required|date',
            'incident_location'    => 'required|string|max:255',
            'incident_description' => 'required|string',
            'recorded_by'          => 'required|string|max:255',
            'status'               => 'required|string',
            'attachments.*'        => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);
    
        $blotter = Blotter::findOrFail($id);
        $blotter->update($request->only([
            'incident_type', 'incident_date', 'incident_location',
            'incident_description', 'status', 'recorded_by', 'remarks',
        ]));
    
        // Update parties if submitted
        if ($request->has('parties')) {
            $blotter->parties()->delete();
            foreach ($request->parties as $party) {
                BlotterParty::create([
                    'blotter_id'  => $blotter->id,
                    'resident_id' => $party['resident_id'] ?? null,
                    'name'        => $party['name'],
                    'address'     => $party['address'] ?? null,
                    'contact'     => $party['contact'] ?? null,
                    'role'        => $party['role'],
                ]);
            }
        }
    
        // Add new attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('blotter_attachments', 'public');
                BlotterAttachment::create([
                    'blotter_id' => $blotter->id,
                    'file_name'  => $file->getClientOriginalName(),
                    'file_path'  => $path,
                    'file_type'  => $file->getMimeType(),
                ]);
            }
        }
    
        return redirect()->route('blotter.view', $blotter->id)
                         ->with('success', 'Blotter entry updated successfully.');
    }
    
    public function blotterDelete($id)
    {
        Blotter::findOrFail($id)->delete();
        return redirect()->route('blotter.index')
                         ->with('success', 'Blotter entry deleted.');
    }
    
    public function blotterDeleteAttachment($attachmentId)
    {
        $attachment = BlotterAttachment::findOrFail($attachmentId);
        \Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();
        return back()->with('success', 'Attachment removed.');
    }
    
    public function blotterPrint($id)
    {
        $blotter = Blotter::with(['parties', 'attachments'])->findOrFail($id);
        return view('blotter.print', compact('blotter'));
    }
    
    // Yajra DataTable
    public function getBlotters()
    {
        $blotters = Blotter::query();
    
        return DataTables::of($blotters)
            ->addColumn('complainants', function ($b) {
                return $b->complainants()->pluck('name')->join(', ') ?: '—';
            })
            ->addColumn('respondents', function ($b) {
                return $b->respondents()->pluck('name')->join(', ') ?: '—';
            })
            ->addColumn('status_badge', function ($b) {
                $colors = [
                    'Active'                        => 'danger',
                    'Under Investigation'           => 'warning',
                    'Settled'                       => 'success',
                    'Dismissed'                     => 'secondary',
                    'Referred to Higher Authority'  => 'info',
                ];
                $color = $colors[$b->status] ?? 'secondary';
                return '<span class="badge bg-' . $color . '">' . $b->status . '</span>';
            })
            ->addColumn('action', function ($b) {
                return '
                    <a href="' . route('blotter.view', $b->id) . '" class="btn btn-sm btn-primary">
                        <i class="fa fa-eye"></i> View
                    </a>
                    <a href="' . route('blotter.edit', $b->id) . '" class="btn btn-sm btn-warning">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <a href="' . route('blotter.print', $b->id) . '" class="btn btn-sm btn-success" target="_blank">
                        <i class="fa fa-print"></i> Print
                    </a>
                    <form action="' . route('blotter.delete', $b->id) . '" method="POST" style="display:inline;"
                          onsubmit="return confirm(\'Delete this blotter entry?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }
    
    // BLOTTER METHODS END

    // OFFICIALS METHODS START

    public function officials()
    {
        return view('officials.index');
    }
    
    public function officialsCreate()
    {
        return view('officials.create');
    }
    
    public function officialsStore(Request $request)
    {
        $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'contact'     => 'nullable|string|max:50',
            'address'     => 'nullable|string|max:255',
            'birthdate'   => 'nullable|date',
            'term_start'  => 'nullable|date',
            'term_end'    => 'nullable|date|after_or_equal:term_start',
            'status'      => 'required|in:Active,Inactive',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $data = $request->except('photo');
    
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('officials', 'public');
        }
    
        $official = Official::create($data);
    
        return redirect()->route('officials.view', $official->id)
                         ->with('success', 'Official added successfully.');
    }
    
    public function officialsView($id)
    {
        $official = Official::findOrFail($id);
        return view('officials.view', compact('official'));
    }
    
    public function officialsEdit($id)
    {
        $official = Official::findOrFail($id);
        return view('officials.edit', compact('official'));
    }
    
    public function officialsUpdate(Request $request, $id)
    {
        $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'contact'     => 'nullable|string|max:50',
            'address'     => 'nullable|string|max:255',
            'birthdate'   => 'nullable|date',
            'term_start'  => 'nullable|date',
            'term_end'    => 'nullable|date|after_or_equal:term_start',
            'status'      => 'required|in:Active,Inactive',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $official = Official::findOrFail($id);
        $data = $request->except('photo');
    
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($official->photo) {
                Storage::disk('public')->delete($official->photo);
            }
            $data['photo'] = $request->file('photo')->store('officials', 'public');
        }
    
        $official->update($data);
    
        return redirect()->route('officials.view', $official->id)
                         ->with('success', 'Official updated successfully.');
    }
    
    public function officialsDelete($id)
    {
        $official = Official::findOrFail($id);
        if ($official->photo) {
            Storage::disk('public')->delete($official->photo);
        }
        $official->delete();
        return redirect()->route('officials.index')
                         ->with('success', 'Official removed.');
    }
    
    public function officialsId($id)
    {
        $official = Official::findOrFail($id);
        return view('officials.id', compact('official'));
    }
    
    // Yajra DataTable
    public function getOfficials()
    {
        $officials = Official::query();
    
        return DataTables::of($officials)
            ->addColumn('full_name', fn($o) => $o->first_name . ' ' . $o->last_name)
            ->addColumn('photo_thumb', function ($o) {
                $src = $o->photo
                    ? asset('storage/' . $o->photo)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($o->first_name . '+' . $o->last_name) . '&background=2d6a4f&color=fff&size=64';
                return '<img src="' . $src . '" width="36" height="36"
                            style="border-radius:50%; object-fit:cover;">';
            })
            ->addColumn('status_badge', function ($o) {
                $color = $o->status === 'Active' ? 'success' : 'secondary';
                return '<span class="badge bg-' . $color . '">' . $o->status . '</span>';
            })
            ->addColumn('term', function ($o) {
                if ($o->term_start && $o->term_end) {
                    return $o->term_start->format('M Y') . ' – ' . $o->term_end->format('M Y');
                }
                return '—';
            })
            ->addColumn('action', function ($o) {
                return '
                    <a href="' . route('officials.view', $o->id) . '" class="btn btn-sm btn-primary">
                        <i class="fa fa-eye"></i> View
                    </a>
                    <a href="' . route('officials.edit', $o->id) . '" class="btn btn-sm btn-warning">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <a href="' . route('officials.id', $o->id) . '" class="btn btn-sm btn-info" target="_blank">
                        <i class="fa fa-id-card"></i> ID
                    </a>
                    <form action="' . route('officials.delete', $o->id) . '" method="POST" style="display:inline;"
                          onsubmit="return confirm(\'Remove this official?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                ';
            })
            ->rawColumns(['photo_thumb', 'status_badge', 'action'])
            ->make(true);
    }
    
    // OFFICIALS METHODS END

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
