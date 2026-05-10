<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
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

    // ── REPORTS ───────────────────────────────────────────────────────────────
    public function reports(Request $request)
    {
        $period = $request->get('period', 'all'); // all, monthly, quarterly, annual
        $query  = $this->applyPeriodFilter(Resident::query(), $period);

        $totalResidents = (clone $query)->count();
        $voters         = (clone $query)->where('is_voter', 1)->count();
        $nonVoters      = $totalResidents - $voters;
        $minors         = (clone $query)->where('age', '<', 18)->count();
        $adults         = (clone $query)->whereBetween('age', [18, 59])->count();
        $seniors        = (clone $query)->where('age', '>=', 60)->count();
        $male           = (clone $query)->where('sex', 'Male')->count();
        $female         = (clone $query)->where('sex', 'Female')->count();

        $civilStatus = (clone $query)
            ->select('civil_status', DB::raw('count(*) as total'))
            ->groupBy('civil_status')
            ->pluck('total', 'civil_status');

        $statusBreakdown = (clone $query)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('reports.index', compact(
            'totalResidents', 'voters', 'nonVoters',
            'minors', 'adults', 'seniors',
            'male', 'female',
            'civilStatus', 'statusBreakdown',
            'period'
        ));
    }

    // ── DATATABLE FOR REPORT TABLE ────────────────────────────────────────────
    public function getReportsData(Request $request)
    {
        $period = $request->get('period', 'all');
        $query  = $this->applyPeriodFilter(Resident::query(), $period);

        return DataTables::of($query)
            ->addColumn('full_name', fn($r) => $r->first_name . ' ' . $r->last_name)
            ->editColumn('is_voter',  fn($r) => $r->is_voter ? 'Registered' : 'Not Registered')
            ->make(true);
    }

    // ── EXPORT TO PDF ─────────────────────────────────────────────────────────
    public function exportPdf(Request $request)
    {
        $period    = $request->get('period', 'all');
        $query     = $this->applyPeriodFilter(Resident::query(), $period);
        $residents = $query->get();

        $summary = [
        'total'   => $residents->count(),
        'voters'  => $residents->where('is_voter', 1)->count(),
        'minors'  => $residents->filter(fn($r) => $r->age < 18)->count(),
        'adults'  => $residents->filter(fn($r) => $r->age >= 18 && $r->age <= 59)->count(),
        'seniors' => $residents->filter(fn($r) => $r->age >= 60)->count(),
        'male'    => $residents->where('sex', 'Male')->count(),
        'female'  => $residents->where('sex', 'Female')->count(),
        'period'  => $period,
    ];

        $pdf = Pdf::loadView('reports.pdf', compact('residents', 'summary'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('barangay-report-' . now()->format('Y-m-d') . '.pdf');
    }

     // ── EXPORT TO EXCEL (CSV) ─────────────────────────────────────────────────
    public function exportExcel(Request $request)
    {
        $period    = $request->get('period', 'all');
        $residents = $this->applyPeriodFilter(Resident::query(), $period)->get();

        $filename = 'barangay-report-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($residents, $period) {
            $file = fopen('php://output', 'w');

            // Title row
            fputcsv($file, ['Barangay Resident Report - Period: ' . ucfirst($period)]);
            fputcsv($file, ['Generated: ' . now()->format('F d, Y h:i A')]);
            fputcsv($file, []); // blank row

            // Summary
            fputcsv($file, ['SUMMARY']);
            fputcsv($file, ['Total Residents', $residents->count()]);
            fputcsv($file, ['Registered Voters', $residents->where('is_voter', 1)->count()]);
            fputcsv($file, ['Minors (< 18)', $residents->filter(fn($r) => $r->age < 18)->count()]);
            fputcsv($file, ['Adults (18-59)', $residents->filter(fn($r) => $r->age >= 18 && $r->age <= 59)->count()]);
            fputcsv($file, ['Seniors (60+)', $residents->filter(fn($r) => $r->age >= 60)->count()]);
            fputcsv($file, ['Male', $residents->where('sex', 'Male')->count()]);
            fputcsv($file, ['Female', $residents->where('sex', 'Female')->count()]);
            fputcsv($file, []); // blank row

            // Column headers
            fputcsv($file, ['Full Name', 'Age', 'Sex', 'Civil Status', 'Voter Status', 'Status', 'Purok', 'Date Added']);

            // Data rows
            foreach ($residents as $resident) {
                fputcsv($file, [
                    $resident->first_name . ' ' . $resident->last_name,
                    $resident->age,
                    $resident->sex,
                    $resident->civil_status,
                    $resident->is_voter ? 'Registered' : 'Not Registered',
                    $resident->status,
                    $resident->purok ?? '—',
                    $resident->created_at?->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
 

    // ── PERIOD FILTER HELPER ──────────────────────────────────────────────────
    private function applyPeriodFilter($query, string $period)
    {
        return match ($period) {
            'monthly'   => $query->whereMonth('created_at', now()->month)
                                 ->whereYear('created_at', now()->year),
            'quarterly' => $query->whereBetween('created_at', [
                                now()->firstOfQuarter(),
                                now()->lastOfQuarter(),
                            ]),
            'annual'    => $query->whereYear('created_at', now()->year),
            default     => $query,
        };
    }
}
