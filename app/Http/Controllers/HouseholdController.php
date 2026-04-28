<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Household;

class HouseholdController extends Controller
{
    //****HOUSEHOLD METHODS****

    public function householdIndex() //Household List
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

    //****HOUSEHOLD METHODS END****
}