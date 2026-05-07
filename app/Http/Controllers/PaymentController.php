<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Resident;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
        // ── PAYMENTS (New Section) ────────────────────────────────────────────────
    public function paymentDashboard()
    {
        $payments = Payment::with('resident')->latest()->get();
        $totalCollected = Payment::sum('amount');

        return view('payments.index', compact('payments', 'totalCollected'));
    }

    public function paymentStore(Request $request)
    {
        $request->validate([
            'resident_id' => 'required',
            'type' => 'required',
            'amount' => 'required|numeric',
        ]);

        Payment::create($request->all());

        return redirect()->back()->with('success', 'Payment recorded!');
    }

    // ── YAJRA DATATABLE ───────────────────────────────────────────────────────
    public function getResidents()
    {
        $residents = Resident::query();

        return DataTables::of($residents)
            ->addColumn('action', function ($resident) {
                return '
                    <a href="' . route('residents.view', $resident->id) . '" class="btn btn-sm btn-primary">View</a>
                    <a href="' . route('residents.edit', $resident->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <form action="' . route('residents.delete', $resident->id) . '" method="POST" style="display:inline;"
                          onsubmit="return confirm(\'Delete this resident?\')">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
