<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Document;
use App\Models\Business;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function paymentDashboard()
    {
        return view('payments.index');
    }

    public function getData()
    {
        $payments = Payment::with('payable')->latest();

        return DataTables::of($payments)
            ->addColumn('reference', function ($payment) {
                $payable = $payment->payable;
                if ($payment->payable_type === 'App\\Models\\Document') {
                    return 'Document #' . $payable->id;
                }
                return 'Business #' . $payable->id;
            })
            ->addColumn('name', function ($payment) {
                $payable = $payment->payable;
                if ($payment->payable_type === 'App\\Models\\Document') {
                    return $payable->resident->first_name . ' ' . $payable->resident->last_name;
                }
                return $payable->owner_name;
            })
            ->addColumn('type', function ($payment) {
                $payable = $payment->payable;
                if ($payment->payable_type === 'App\\Models\\Document') {
                    return $payable->document_type;
                }
                return $payable->business_type . ' Permit';
            })
            ->addColumn('amount_formatted', function ($payment) {
                return '₱' . number_format($payment->amount, 2);
            })
            ->addColumn('status_badge', function ($payment) {
                $color = $payment->status === 'Paid' ? 'success' : 'warning';
                return '<span class="badge bg-' . $color . '">' . $payment->status . '</span>';
            })
            ->addColumn('created_at', function ($payment) {
                return $payment->created_at->format('M d, Y h:i A');
            })
            ->addColumn('action', function ($payment) {
                $buttons = '<a href="' . route('payments.receipt', $payment->id) . '"
                    class="btn btn-sm btn-primary" target="_blank">
                    <i class="fa fa-print"></i> Receipt</a> ';

                if (Auth::user()->hasRole('admin')) {
                    $buttons .= '
                        <form action="' . route('payments.delete', $payment->id) . '"
                            method="POST" style="display:inline;"
                            onsubmit="return confirm(\'Delete this payment?\')">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    ';
                }

                return $buttons;
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payable_type' => 'required|in:document,business',
            'payable_id'   => 'required|integer',
            'amount'       => 'required|numeric|min:0',
            'or_number'    => 'nullable|string|max:100',
            'notes'        => 'nullable|string|max:500',
        ]);

        $modelClass = $request->payable_type === 'document'
            ? Document::class
            : Business::class;

        $payable = $modelClass::findOrFail($request->payable_id);

        Payment::create([
            'payable_type' => $modelClass,
            'payable_id'   => $payable->id,
            'or_number'    => $request->or_number,
            'amount'       => $request->amount,
            'status'       => 'Paid',
            'notes'        => $request->notes,
            'paid_at'      => now(),
        ]);

        // Auto-update status to Paid
        $payable->update(['status' => 'Paid']);

        return redirect()->back()->with('success', 'Payment recorded successfully!');
    }

    public function receipt($id)
    {
        $payment = Payment::with('payable')->findOrFail($id);
        return view('payments.receipt', compact('payment'));
    }

    public function delete($id)
    {
        Payment::findOrFail($id)->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted.');
    }
}