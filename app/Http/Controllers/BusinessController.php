<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use Illuminate\Support\Str;

class BusinessController extends Controller
{
    public function business()
    {
        return view('business.index');
    }

    public function businessAdd()
    {
        return view('business.add');
    }

    public function businessView($id)
    {
        // withTrashed so admins can still view a soft-deleted business
        $business = Business::withTrashed()->findOrFail($id);
        return view('business.view', compact('business'));
    }

    public function businessEdit($id)
    {
        $business = Business::findOrFail($id);
        return view('business.edit', compact('business'));
    }

    public function businessStore(Request $request)
    {
        $data = $request->all();
        $data['permit_number']    = 'BP-' . date('Y') . '-' . strtoupper(Str::random(6));
        $data['reference_number'] = 'REF-' . strtoupper(Str::random(8));
        Business::create($data);
        return redirect()->route('business.index')
                         ->with('success', 'Business registered successfully.');
    }

    public function businessUpdate(Request $request, $id)
    {
        $business = Business::findOrFail($id);
        $business->update($request->all());
        return redirect()->route('business.index')
                         ->with('success', 'Business updated successfully.');
    }

    /**
     * Soft-delete a business.
     */
    public function businessDelete($id)
    {
        Business::findOrFail($id)->delete();
        return redirect()->route('business.index')
                         ->with('success', 'Business moved to trash.');
    }

    /**
     * Restore a soft-deleted business.
     */
    public function restore($id)
    {
        Business::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('business.index')
                         ->with('success', 'Business restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted business.
     */
    public function forceDelete($id)
    {
        Business::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('business.index')
                         ->with('success', 'Business permanently deleted.');
    }

    /**
     * DataTables source. Accepts ?trashed=1 for soft-deleted records.
     */
    public function getBusinesses(Request $request)
    {
        $showTrashed = $request->boolean('trashed');

        $businesses = $showTrashed
            ? Business::onlyTrashed()
            : Business::query();

        return DataTables::of($businesses)
            ->addColumn('action', function ($business) use ($showTrashed) {
                $buttons = '';

                if ($showTrashed) {
                    // ── Trashed view: Restore + Force Delete ──────────────────
                    if (Auth::user()->hasRole('admin')) {
                        $buttons .= '
                            <form action="' . route('business.restore', $business->id) . '"
                                  method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-sm btn-warning">
                                    <i class="fa fa-rotate-left"></i> Restore
                                </button>
                            </form> ';

                        $buttons .= '
                            <form action="' . route('business.forceDelete', $business->id) . '"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm(\'Permanently delete this business? This cannot be undone.\')">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Delete Forever
                                </button>
                            </form>';
                    }
                } else {
                    // ── Active view: View + Edit + Soft Delete ────────────────
                    $buttons .= '<a href="' . route('business.view', $business->id) . '"
                        class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a> ';

                    if (Auth::user()->hasAnyRole(['admin', 'secretary'])) {
                        $buttons .= '<a href="' . route('business.edit', $business->id) . '"
                            class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</a> ';
                    }

                    if (Auth::user()->hasRole('admin')) {
                        $buttons .= '
                            <form action="' . route('business.delete', $business->id) . '"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm(\'Move this business to trash?\')">
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