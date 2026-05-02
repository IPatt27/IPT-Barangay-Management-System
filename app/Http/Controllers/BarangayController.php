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

    public function documents()
    {
        return view('documents');
    }

    public function blotter()
    {
        return view('blotter');
    }

    public function officials()
    {
        return view('officials');
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