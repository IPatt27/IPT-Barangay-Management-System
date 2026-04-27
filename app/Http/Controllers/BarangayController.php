<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Resident;
use App\Models\Purok;
use App\Models\Household;

class BarangayController extends Controller
{
    //****RESIDENTS METHODS SART****


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



    public function documents()
    {
        return view('documents');
    }

    public function blotter()
    {
        return view('blotter');
    }


    //============================================================================================================

    //****PUROK METHODS****

    public function purok() //Purok List
    {
        return view('household.purok-index');
    }
    
    public function purokAdd() //Add Purok
    {
        return view('household.purokAdd');
    }

    public function purokEdit($id) //Edit Purok
    {
        $purok = Purok::findOrFail($id);
        return view('household.purokEdit', compact('purok'));
    }

    public function purokUpdate(Request $request, $id) //update Purok
    {
        $purok = Purok::findOrFail($id);
        $purok->update($request->all());
        return redirect()->route('household.purok-index');
    }

    public function purokView($id) //View Purok
    {
        $purok = Purok::findOrFail($id);
        return view('household.purokView', compact('purok'));
    }

    
    public function purokDelete($id) //Delete Purok
    {
        $purok = Purok::findOrFail($id);
        $purok->delete();
        return redirect()->route('household.purok-index');
    }

    //PUROK YAJRA TABLE
    public function getPuroks()
    {
        $puroks = Purok::withCount('households');
        return DataTables::of($puroks)
            ->addColumn('action', function($purok) {
                return '
                    <a href="' . route('purok.view', $purok->id) . '" class="btn btn-sm btn-primary">View</a>
                    <a href="' . route('purok.edit', $purok->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <form action="' . route('purok.delete', $purok->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    //============================================================================================================

    //****HOUSEHOLD METHODS****
    public function householdIndex() // <-- Added this method
    {
        return view('household.household-index'); 
    }

    public function householdAdd() //Add Household
    {
        return view('household.householdAdd');
    }

    public function householdEdit($id) //Edit Household
    {
        $household = Household::findOrFail($id);
        return view('household.householdEdit', compact('household'));
    }

    public function householdView($id) //View Household
    {
        $household = Household::findOrFail($id);
        return view('household.householdView', compact('household'));
    }

    public function purokStore(Request $request) // Store new purok
    {
        Purok::create($request->all());
        return redirect()->route('household.purok-index');
    }

    // HOUSEHOLD YAJRA TABLE
    public function getHouseholds()
    {
    $households = Household::with('purok');
    return DataTables::of($households)
        ->addColumn('purok_name', function($household) {
            return $household->purok->name ?? 'N/A';
        })
        ->addColumn('action', function($household) {
            return '
                <a href="' . route('household.view', $household->id) . '" class="btn btn-sm btn-primary">View</a>
                <a href="' . route('household.edit', $household->id) . '" class="btn btn-sm btn-warning">Edit</a>
                <form action="' . route('household.delete', $household->id) . '" method="POST" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    
    public function householdDelete($id) // Delete household
    {
        $household = Household::findOrFail($id);
        $household->delete();
        return redirect()->route('household.household-index');
    }

    // ****PUROK - HOUSEHOLD METHODS END****


    public function business()
    {
        return view('business');
    }

    public function officials()
    {
        return view('officials');
    }

    public function committee()
    {
        return view('committee');
    }

    public function reports()
    {
        return view('reports');
    }

    public function users()
    {
        return view('users');
    }

    public function technical()
    {
        return view('technical');
    }
    public function dashboard()
    {
    return view('dashboard');
    }
}