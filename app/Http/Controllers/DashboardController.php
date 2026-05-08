<?php

namespace App\Http\Controllers;

use App\Models\Resident;

class DashboardController extends Controller
{
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