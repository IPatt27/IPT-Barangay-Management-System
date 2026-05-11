<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Purok;
use Illuminate\Support\Facades\Auth;

class PurokController extends Controller
{
    public function purok()
    {
        return view('household.purok-index');
    }

    public function purokAdd()
    {
        return view('household.purokAdd');
    }

    public function purokEdit($id)
    {
        $purok = Purok::findOrFail($id);
        return view('household.purokEdit', compact('purok'));
    }

    public function purokUpdate(Request $request, $id)
    {
        $purok = Purok::findOrFail($id);
        $purok->update($request->all());
        return redirect()->route('household.purok-index')
                         ->with('success', 'Purok updated successfully.');
    }

    public function purokView($id)
    {
        $purok = Purok::withTrashed()->findOrFail($id);
        return view('household.purokView', compact('purok'));
    }

    public function purokStore(Request $request)
    {
        Purok::create($request->all());
        return redirect()->route('household.purok-index')
                         ->with('success', 'Purok added successfully.');
    }

    /**
     * Soft-delete a purok.
     */
    public function purokDelete($id)
    {
        Purok::findOrFail($id)->delete();
        return redirect()->route('household.purok-index')
                         ->with('success', 'Purok moved to trash.');
    }

    /**
     * Restore a soft-deleted purok.
     */
    public function restore($id)
    {
        Purok::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('household.purok-index')
                         ->with('success', 'Purok restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted purok.
     */
    public function forceDelete($id)
    {
        Purok::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('household.purok-index')
                         ->with('success', 'Purok permanently deleted.');
    }

    /**
     * DataTables source. Accepts ?trashed=1 for soft-deleted records.
     */
    public function getPuroks(Request $request)
    {
        $showTrashed = $request->boolean('trashed');

        $puroks = $showTrashed
            ? Purok::onlyTrashed()->withCount('households')
            : Purok::withCount('households');

        return DataTables::of($puroks)
            ->addColumn('action', function ($purok) use ($showTrashed) {
                $buttons = '';

                if ($showTrashed) {
                    // ── Trashed view: Restore + Force Delete ──────────────────
                    if (Auth::user()->hasRole('admin')) {
                        $buttons .= '
                            <form action="' . route('purok.restore', $purok->id) . '"
                                  method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-sm btn-warning">
                                    <i class="fa fa-rotate-left"></i> Restore
                                </button>
                            </form> ';

                        $buttons .= '
                            <form action="' . route('purok.forceDelete', $purok->id) . '"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm(\'Permanently delete this purok? This cannot be undone.\')">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Delete Forever
                                </button>
                            </form>';
                    }
                } else {
                    // ── Active view: View + Edit + Soft Delete ────────────────
                    $buttons .= '<a href="' . route('purok.view', $purok->id) . '"
                        class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a> ';

                    if (Auth::user()->hasAnyRole(['admin', 'secretary'])) {
                        $buttons .= '<a href="' . route('purok.edit', $purok->id) . '"
                            class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</a> ';
                    }

                    if (Auth::user()->hasRole('admin')) {
                        $buttons .= '
                            <form action="' . route('purok.delete', $purok->id) . '"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm(\'Move this purok to trash?\')">
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