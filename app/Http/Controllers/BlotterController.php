<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blotter;
use App\Models\BlotterParty;
use App\Models\BlotterAttachment;
use App\Models\Resident;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class BlotterController extends Controller
{
    public function index()
    {
        return view('blotter.index');
    }

    public function create()
    {
        $residents = Resident::orderBy('last_name')->get();
        return view('blotter.create', compact('residents'));
    }

    public function store(Request $request)
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

    public function view($id)
    {
        $blotter = Blotter::with(['parties', 'attachments'])->findOrFail($id);
        return view('blotter.view', compact('blotter'));
    }

    public function edit($id)
    {
        $blotter   = Blotter::with('parties')->findOrFail($id);
        $residents = Resident::orderBy('last_name')->get();
        return view('blotter.edit', compact('blotter', 'residents'));
    }

    public function update(Request $request, $id)
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

    public function delete($id)
    {
        Blotter::findOrFail($id)->delete();
        return redirect()->route('blotter.index')
                         ->with('success', 'Blotter entry deleted.');
    }

    public function deleteAttachment($attachmentId)
    {
        $attachment = BlotterAttachment::findOrFail($attachmentId);
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();
        return back()->with('success', 'Attachment removed.');
    }

    public function print($id)
    {
        $blotter = Blotter::with(['parties', 'attachments'])->findOrFail($id);
        return view('blotter.print', compact('blotter'));
    }

    public function getData()
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
                    'Active'                       => 'danger',
                    'Under Investigation'          => 'warning',
                    'Settled'                      => 'success',
                    'Dismissed'                    => 'secondary',
                    'Referred to Higher Authority' => 'info',
                ];
                $color = $colors[$b->status] ?? 'secondary';
                return '<span class="badge bg-' . $color . '">' . $b->status . '</span>';
            })
            ->addColumn('action', function ($b) {
                $buttons = '<a href="' . route('blotter.view', $b->id) . '" class="btn btn-sm btn-primary">
                    <i class="fa fa-eye"></i> View
                </a> ';

                if (Auth::user()->hasAnyRole(['admin', 'secretary'])) {
                    $buttons .= '<a href="' . route('blotter.edit', $b->id) . '" class="btn btn-sm btn-warning">
                        <i class="fa fa-edit"></i> Edit
                    </a> ';
                }

                $buttons .= '<a href="' . route('blotter.print', $b->id) . '" class="btn btn-sm btn-success" target="_blank">
                    <i class="fa fa-print"></i> Print
                </a> ';

                if (Auth::user()->hasRole('admin')) {
                    $buttons .= '
                        <form action="' . route('blotter.delete', $b->id) . '" method="POST" style="display:inline;"
                            onsubmit="return confirm(\'Delete this blotter entry?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    ';
                }

                return $buttons;
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }
}
