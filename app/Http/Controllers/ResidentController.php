<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Resident;
use App\Models\Purok;
use App\Models\Household;

class ResidentController extends Controller
{
    public function residents()
    {
        return view('residents.index');
    }

    public function residentsAdd()
    {
        $puroks = Purok::all();
        $households = Household::all();
        return view('residents.add', compact('puroks', 'households'));
    }

    public function residentsView($id)
    {
        // withTrashed so admins can still view a soft-deleted resident
        $resident = Resident::withTrashed()->findOrFail($id);
        return view('residents.view', compact('resident'));
    }

    public function residentsEdit($id)
    {
        $resident = Resident::findOrFail($id);
        $puroks = Purok::all();
        $households = Household::all();
        return view('residents.edit', compact('resident', 'puroks', 'households'));
    }

    public function residentsStore(Request $request)
    {
        Resident::create($request->all());
        return redirect()->route('residents.index')
                         ->with('success', 'Resident added successfully.');
    }

    public function residentsUpdate(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        $resident->update($request->all());
        return redirect()->route('residents.index')
                         ->with('success', 'Resident updated successfully.');
    }

    /**
     * Soft-delete a resident (moves to trash).
     */
    public function residentsDelete($id)
    {
        Resident::findOrFail($id)->delete();
        return redirect()->route('residents.index')
                         ->with('success', 'Resident moved to trash.');
    }

    /**
     * Restore a soft-deleted resident.
     */
    public function restore($id)
    {
        Resident::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('residents.index')
                         ->with('success', 'Resident restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted resident.
     */
    public function forceDelete($id)
    {
        Resident::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('residents.index')
                         ->with('success', 'Resident permanently deleted.');
    }

    /**
     * DataTables source.
     * Accepts ?trashed=1 to show only soft-deleted records.
     */
    public function getResidents(Request $request)
    {
        $showTrashed = $request->boolean('trashed');

        $residents = $showTrashed
            ? Resident::onlyTrashed()->select('residents.*')
            : Resident::select('residents.*');

        return DataTables::of($residents)
            ->addColumn('action', function ($resident) use ($showTrashed) {
                $buttons = '';

                if ($showTrashed) {
                    
                    // ── Trashed view: Restore + Force Delete ──────────────────
                    if (Auth::user()->hasRole('admin')) {
                        $buttons .= '
                            <form action="' . route('residents.restore', $resident->id) . '"
                                  method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-sm btn-warning">
                                    <i class="fa fa-rotate-left"></i> Restore
                                </button>
                            </form> ';

                        $buttons .= '
                            <form action="' . route('residents.forceDelete', $resident->id) . '"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm(\'Permanently delete this resident? This cannot be undone.\')">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Delete Forever
                                </button>
                            </form>';
                    }
                } else {
                    $buttons .= '<a href="' . route('residents.view', $resident->id) . '"
                        class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a> ';

                    if (Auth::user()->hasAnyRole(['admin', 'secretary'])) {
                        $buttons .= '<a href="' . route('residents.edit', $resident->id) . '"
                            class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</a> ';
                    }

                    if (Auth::user()->hasRole('admin')) {
                        $buttons .= '
                            <form action="' . route('residents.delete', $resident->id) . '"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm(\'Move this resident to trash?\')">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>';
                    }
                }

                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}