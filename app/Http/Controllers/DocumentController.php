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
        $document = Document::with('resident')->findOrFail($id);
        return view('documents.print', compact('document'));
    }

    public function delete($id)
    {
        Document::findOrFail($id)->delete();
        return redirect()->route('documents.index')
                         ->with('success', 'Document deleted.');
    }

    public function getData()
    {
        $documents = Document::with('resident')->select('documents.*');

        return DataTables::of($documents)
            ->addColumn('resident_name', function ($doc) {
                return $doc->resident->first_name . ' ' . $doc->resident->last_name;
            })
            ->addColumn('action', function ($doc) {
                $buttons = '<a href="' . route('documents.print', $doc->id) . '"
                    class="btn btn-sm btn-action-print" target="_blank">
                    <i class="fa fa-print"></i> Print
                </a> ';

                if (Auth::user()->hasRole('admin')) {
                    $buttons .= '
                        <form action="' . route('documents.delete', $doc->id) . '"
                            method="POST" style="display:inline;"
                            onsubmit="return confirm(\'Delete this document?\')">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button class="btn btn-sm btn-action-delete">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    ';
                }

                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
