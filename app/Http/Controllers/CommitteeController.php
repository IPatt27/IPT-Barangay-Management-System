<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Committee;
class CommitteeController extends Controller
{
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
}
