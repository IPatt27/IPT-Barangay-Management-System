<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Household;
use App\Models\Purok;

class HouseholdController extends Controller
{
    //****HOUSEHOLD METHODS****

    public function householdIndex() //Household List
    {
        return view('household.household-index');
    }

    public function householdAdd() //Add Household
    {
        $puroks = Purok::all();
        return view('household.householdAdd', compact('puroks'));
    }

    public function householdStore(Request $request) //Store Household
    {
        Household::create($request->all());
        return redirect()->route('household.household-index');
    }

    public function householdEdit($id) //Edit Household
    {
        $household = Household::findOrFail($id);
        $puroks = Purok::all();
        return view('household.householdEdit', compact('household', 'puroks'));
    }

    public function householdView($id) //View Household
    {
        $household = Household::findOrFail($id);
        return view('household.householdView', compact('household'));
    }

    public function householdUpdate(Request $request, $id) //Update Household
    {
        $household = Household::findOrFail($id);
        $household->update($request->all());
        return redirect()->route('household.household-index');
    }

    public function householdDelete($id) //Delete Household
    {
        $household = Household::findOrFail($id);
        $household->delete();
        return redirect()->route('household.household-index');
    }

    //HOUSEHOLD YAJRA TABLE
    public function getHouseholds()
    {
        $households = Household::with('purok');
        return DataTables::of($households)
            ->addColumn('purok_name', function($household) {
                return $household->purok->name ?? 'N/A';
            })
            ->addColumn('action', function($household) {
                return '
                    <a href="' . route('household.view', $household->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>
                    <a href="' . route('household.edit', $household->id) . '" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</a>
                    <form action="' . route('household.delete', $household->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    //****HOUSEHOLD METHODS END****
}