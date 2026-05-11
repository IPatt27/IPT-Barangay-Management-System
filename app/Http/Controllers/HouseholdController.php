<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Household;
use App\Models\Purok;
use Illuminate\Support\Facades\Auth;

class HouseholdController extends Controller
{
    public function householdIndex()
    {
        return view('household.household-index');
    }

    public function householdAdd()
    {
        $puroks = Purok::all();
        return view('household.householdAdd', compact('puroks'));
    }

    public function householdStore(Request $request)
    {
        Household::create($request->all());
        return redirect()->route('household.household-index')
                         ->with('success', 'Household added successfully.');
    }

    public function householdEdit($id)
    {
        $household = Household::findOrFail($id);
        $puroks = Purok::all();
        return view('household.householdEdit', compact('household', 'puroks'));
    }

    public function householdView($id)
    {
        // withTrashed so admins can still view a soft-deleted household
        $household = Household::withTrashed()->findOrFail($id);
        return view('household.householdView', compact('household'));
    }

    public function householdUpdate(Request $request, $id)
    {
        $household = Household::findOrFail($id);
        $household->update($request->all());
        return redirect()->route('household.household-index')
                         ->with('success', 'Household updated successfully.');
    }

    /**
     * Soft-delete a household.
     */
    public function householdDelete($id)
    {
        Household::findOrFail($id)->delete();
        return redirect()->route('household.household-index')
                         ->with('success', 'Household moved to trash.');
    }

    /**
     * Restore a soft-deleted household.
     */
    public function restore($id)
    {
        Household::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('household.household-index')
                         ->with('success', 'Household restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted household.
     */
    public function forceDelete($id)
    {
        Household::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('household.household-index')
                         ->with('success', 'Household permanently deleted.');
    }

    /**
     * DataTables source. Accepts ?trashed=1 for soft-deleted records.
     */
    public function getHouseholds(Request $request)
    {
        $showTrashed = $request->boolean('trashed');

        $households = $showTrashed
            ? Household::onlyTrashed()->with('purok')
            : Household::with('purok');

        return DataTables::of($households)
            ->addColumn('purok_name', function ($household) {
                return $household->purok->name ?? 'N/A';
            })
            ->addColumn('action', function ($household) use ($showTrashed) {
                $buttons = '';

                if ($showTrashed) {
                    // ── Trashed view: Restore + Force Delete ──────────────────
                    if (Auth::user()->hasRole('admin')) {
                        $buttons .= '
                            <form action="' . route('household.restore', $household->id) . '"
                                  method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-sm btn-warning">
                                    <i class="fa fa-rotate-left"></i> Restore
                                </button>
                            </form> ';

                        $buttons .= '
                            <form action="' . route('household.forceDelete', $household->id) . '"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm(\'Permanently delete this household? This cannot be undone.\')">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Delete Forever
                                </button>
                            </form>';
                    }
                } else {
                    // ── Active view: View + Edit + Soft Delete ────────────────
                    $buttons .= '<a href="' . route('household.view', $household->id) . '"
                        class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a> ';

                    if (Auth::user()->hasAnyRole(['admin', 'secretary'])) {
                        $buttons .= '<a href="' . route('household.edit', $household->id) . '"
                            class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</a> ';
                    }

                    if (Auth::user()->hasRole('admin')) {
                        $buttons .= '
                            <form action="' . route('household.delete', $household->id) . '"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm(\'Move this household to trash?\')">
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