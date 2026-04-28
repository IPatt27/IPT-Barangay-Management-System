<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Resident;
use App\Models\Purok;
use App\Models\Household;

class ResidentController extends Controller
{
    //****RESIDENTS METHODS START****

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
        $resident = Resident::findOrFail($id);
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
        return redirect()->route('residents.index');
    }

    public function residentsUpdate(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        $resident->update($request->all());
        return redirect()->route('residents.index');
    }

    public function residentsDelete($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();
        return redirect()->route('residents.index');
    }

    //RESIDENT YAJRA TABLE
    public function getResidents()
    {
        $residents = Resident::query();
        return DataTables::of($residents)
            ->addColumn('action', function($resident) {
                return '
                    <a href="' . route('residents.view', $resident->id) . '" class="btn btn-sm btn-primary">View</a>
                    <a href="' . route('residents.edit', $resident->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <form action="' . route('residents.delete', $resident->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    //****RESIDENTS METHODS END****
}