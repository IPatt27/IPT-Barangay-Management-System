<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Official;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class OfficialController extends Controller
{
    public function index()
    {
        return view('officials.index');
    }

    public function create()
    {
        return view('officials.create');
    }

    public function store(Request $request)
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

    public function view($id)
    {
        $official = Official::findOrFail($id);
        return view('officials.view', compact('official'));
    }

    public function edit($id)
    {
        $official = Official::findOrFail($id);
        return view('officials.edit', compact('official'));
    }

    public function update(Request $request, $id)
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
            if ($official->photo) {
                Storage::disk('public')->delete($official->photo);
            }
            $data['photo'] = $request->file('photo')->store('officials', 'public');
        }

        $official->update($data);

        return redirect()->route('officials.view', $official->id)
                         ->with('success', 'Official updated successfully.');
    }

    public function delete($id)
    {
        $official = Official::findOrFail($id);
        if ($official->photo) {
            Storage::disk('public')->delete($official->photo);
        }
        $official->delete();
        return redirect()->route('officials.index')
                         ->with('success', 'Official removed.');
    }

    public function idCard($id)
    {
        $official = Official::findOrFail($id);
        return view('officials.id', compact('official'));
    }

    public function getData()
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
}
