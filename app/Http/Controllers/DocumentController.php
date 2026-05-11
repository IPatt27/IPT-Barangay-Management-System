<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Resident;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        return view('documents.index');
    }

    public function create()
    {
        $residents = Resident::orderBy('last_name')->get();
        return view('documents.create', compact('residents'));
    }

    public function store(Request $request)
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

        return redirect()->route('documents.print', $document->id)
                         ->with('success', 'Document issued successfully.');
    }

    public function print($id)
    {
        // withTrashed so admins can still reprint a soft-deleted document
        $document = Document::withTrashed()->with('resident')->findOrFail($id);
        return view('documents.print', compact('document'));
    }

    /**
     * Soft-delete a document (moves it to the trash).
     */
    public function delete($id)
    {
        Document::findOrFail($id)->delete();

        return redirect()->route('documents.index')
                         ->with('success', 'Document moved to trash.');
    }

    /**
     * Restore a soft-deleted document.
     */
    public function restore($id)
    {
        Document::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('documents.index')
                         ->with('success', 'Document restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted document.
     * Only available when the record is already soft-deleted.
     */
    public function forceDelete($id)
    {
        Document::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('documents.index')
                         ->with('success', 'Document permanently deleted.');
    }

    /**
     * DataTables data source.
     * Accepts ?trashed=1 to show only soft-deleted records.
     */
    public function getData(Request $request)
    {
        $showTrashed = $request->boolean('trashed');

        $query = $showTrashed
            ? Document::onlyTrashed()->with('resident')->select('documents.*')
            : Document::with('resident')->select('documents.*');

        return DataTables::of($query)
            ->addColumn('resident_name', function ($doc) {
                return $doc->resident->first_name . ' ' . $doc->resident->last_name;
            })
            ->addColumn('action', function ($doc) use ($showTrashed) {
                $buttons = '';

                if ($showTrashed) {
                    // ── Trashed view: Restore + Force Delete ──────────────────
                    if (Auth::user()->hasRole('admin')) {
                        $buttons .= '
                            <form action="' . route('documents.restore', $doc->id) . '"
                                  method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-sm btn-warning">
                                    <i class="fa fa-rotate-left"></i> Restore
                                </button>
                            </form> ';

                        $buttons .= '
                            <form action="' . route('documents.forceDelete', $doc->id) . '"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm(\'Permanently delete this document? This cannot be undone.\')">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Delete Forever
                                </button>
                            </form>';
                    }
                } else {
                    // ── Active view: Print + Pay + (Soft) Delete ──────────────
                    $buttons .= '<a href="' . route('documents.print', $doc->id) . '"
                        class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</a> ';

                    if (Auth::user()->hasAnyRole(['admin', 'secretary'])) {
                        if ($doc->status !== 'Paid') {
                            $buttons .= '<button class="btn btn-sm btn-success"
                                data-bs-toggle="modal"
                                data-bs-target="#payModal"
                                data-id="' . $doc->id . '"
                                data-type="document"
                                data-name="' . $doc->resident->first_name . ' ' . $doc->resident->last_name . '"
                                data-doctype="' . $doc->document_type . '"
                                onclick="openPayModal(this)">
                                <i class="fa fa-money-bill"></i> Pay
                            </button> ';
                        }
                    }

                    if (Auth::user()->hasRole('admin')) {
                        $buttons .= '
                            <form action="' . route('documents.delete', $doc->id) . '"
                                method="POST" style="display:inline;"
                                onsubmit="return confirm(\'Move this document to trash?\')">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        ';
                    }
                }

                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}