<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Purok;

class PurokController extends Controller
{
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

    public function purokUpdate(Request $request, $id) //Update Purok
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

    public function purokStore(Request $request) //Store new purok
    {
        Purok::create($request->all());
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

    //****PUROK METHODS END****
}