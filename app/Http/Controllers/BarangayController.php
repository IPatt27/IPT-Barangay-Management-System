<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Resident;
use App\Models\Purok;
use App\Models\Household;
use App\Models\Business;
use App\Models\Committee;
use Illuminate\Support\Str;


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


    // ****BUSINESS METHODS START****
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
        $business = Business::findOrFail($id);
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
        return redirect()->route('business.index');
    }

    public function businessUpdate(Request $request, $id)
    {
        $business = Business::findOrFail($id);
        $business->update($request->all());
        return redirect()->route('business.index');
    }

    public function businessDelete($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();
        return redirect()->route('business.index');
    }

    public function getBusinesses()
    {
        $businesses = Business::query();
        return DataTables::of($businesses)
            ->addColumn('action', function($business) {
                return '
                    <a href="' . route('business.view', $business->id) . '" class="btn btn-sm btn-primary">View</a>
                    <a href="' . route('business.edit', $business->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <form action="' . route('business.delete', $business->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    // ****BUSINESS METHODS END****

    public function officials()
    {
        return view('officials');
    }

    // ****COMMITTEE METHODS START****
    public function committee()
    {
        return view('committee.index');
    }

    public function committeeAdd()
    {
        return view('committee.add');
    }

    public function committeeView($id)
    {
        $committee = Committee::findOrFail($id);
        return view('committee.view', compact('committee'));
    }

    public function committeeEdit($id)
    {
        $committee = Committee::findOrFail($id);
        return view('committee.edit', compact('committee'));
    }

    public function committeeStore(Request $request)
    {
        Committee::create($request->all());
        return redirect()->route('committee.index');
    }

    public function committeeUpdate(Request $request, $id)
    {
        $committee = Committee::findOrFail($id);
        $committee->update($request->all());
        return redirect()->route('committee.index');
    }

    public function committeeDelete($id)
    {
        $committee = Committee::findOrFail($id);
        $committee->delete();
        return redirect()->route('committee.index');
    }

    public function getCommittees()
    {
        $committees = Committee::query();
        return DataTables::of($committees)
            ->addColumn('action', function($committee) {
                return '
                    <a href="' . route('committee.view', $committee->id) . '" class="btn btn-sm btn-primary">View</a>
                    <a href="' . route('committee.edit', $committee->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <form action="' . route('committee.delete', $committee->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    // ****COMMITTEE METHODS END****

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