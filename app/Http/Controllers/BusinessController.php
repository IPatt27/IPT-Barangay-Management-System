<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use Illuminate\Support\Str;

class BusinessController extends Controller
{
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

            $buttons = '<a href="' . route('business.view', $business->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a> ';

            if (Auth::user()->hasAnyRole(['admin', 'secretary'])) {
                $buttons .= '<a href="' . route('business.edit', $business->id) . '" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</a> ';
            }

            if (Auth::user()->hasRole('admin')) {
                $buttons .= '
                    <form action="' . route('business.delete', $business->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </form>
                ';
            }

            return $buttons;
        })
        ->rawColumns(['action'])
        ->make(true);
}
    // ****BUSINESS METHODS END****
}
