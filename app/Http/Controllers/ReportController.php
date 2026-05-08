<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // ── REPORTS ───────────────────────────────────────────────────────────────
    public function reports()
    {
        $totalResidents = Resident::count();
        $voters = Resident::where('is_voter', 1)->count();
        $minors = Resident::where('age', '<', 18)->count();
        $adults = Resident::whereBetween('age', [18, 59])->count();
        $seniors = Resident::where('age', '>=', 60)->count();

        $civilStatus = Resident::select('civil_status', DB::raw('count(*) as total'))
            ->groupBy('civil_status')
            ->pluck('total', 'civil_status');

        $statusBreakdown = Resident::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('reports.index', compact(
            'totalResidents', 'voters', 'minors', 'adults', 'seniors',
            'civilStatus', 'statusBreakdown'
        ));
    }

    public function getReportsData()
    {
        $residents = Resident::query();

        return DataTables::of($residents)
            ->addColumn('full_name', function ($resident) {
                return $resident->first_name . ' ' . $resident->last_name;
            })
            ->editColumn('is_voter', function ($resident) {
                return $resident->is_voter ? 'Registered' : 'Not Registered';
            })
            ->make(true);
    }
}
