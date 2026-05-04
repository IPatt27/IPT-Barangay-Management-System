<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Resident;
use App\Models\Purok;
use App\Models\Household;
use App\Models\Business;
use App\Models\Committee;
use App\Models\Document;
use App\Models\Blotter;
use App\Models\BlotterParty;
use App\Models\BlotterAttachment;
use App\Models\Official;
use Illuminate\Support\Str;


class BarangayController extends Controller
{ 

    // ── REPORTS ───────────────────────────────────────────────────────────────
    public function reports()
    {
        $totalResidents = Resident::count();
        $maleCount      = Resident::where('sex', 'Male')->count();
        $femaleCount    = Resident::where('sex', 'Female')->count();
        $voters         = Resident::where('is_voter', 1)->count();
        $nonVoters      = $totalResidents - $voters;
        $minors         = Resident::where('age', '<', 18)->count();
        $adults         = Resident::whereBetween('age', [18, 59])->count();
        $seniors        = Resident::where('age', '>=', 60)->count();

        // Civil status breakdown
        $civilStatus = Resident::selectRaw('civil_status, count(*) as count')
            ->groupBy('civil_status')
            ->pluck('count', 'civil_status');

        // Status breakdown
        $statusBreakdown = Resident::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('reports', compact(
            'totalResidents', 'maleCount', 'femaleCount',
            'voters', 'nonVoters', 'minors', 'adults', 'seniors',
            'civilStatus', 'statusBreakdown'
        ));
    }

    public function users()
    {
        return view('users');
    }

    
    // ── DASHBOARD ─────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $totalResidents = Resident::count();
        $maleCount      = Resident::where('sex', 'Male')->count();
        $femaleCount    = Resident::where('sex', 'Female')->count();
        $voters         = Resident::where('is_voter', 1)->count();
        $minors         = Resident::where('age', '<', 18)->count();
        $adults         = Resident::whereBetween('age', [18, 59])->count();
        $seniors        = Resident::where('age', '>=', 60)->count();

        return view('dashboard', compact(
            'totalResidents', 'maleCount', 'femaleCount',
            'voters', 'minors', 'adults', 'seniors'
        ));
    }
}
