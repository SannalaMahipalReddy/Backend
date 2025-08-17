<?php

namespace App\Http\Controllers;

use App\Models\BillPayment;
use Illuminate\Http\Request;

class BillPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = BillPayment::all();
        return response()->json($payments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'bill_id' => 'required|exists:bills,id',
            'user_id' => 'required|exists:users,id',
            'amount_paid' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,partial',
        ]);

        // Create new bill payment
        $billPayment = BillPayment::create($request->all());

        return response()->json([
            'message' => 'Bill payment created successfully',
            'billPayment' => $billPayment,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $billPayment = BillPayment::find($id);

        if (!$billPayment) {
            return response()->json(['message' => 'Bill payment not found'], 404);
        }

        return response()->json($billPayment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $billPayment = BillPayment::find($id);

        if (!$billPayment) {
            return response()->json(['message' => 'Bill payment not found'], 404);
        }

        // Validate incoming request
        $request->validate([
            'bill_id' => 'required|exists:bills,id',
            'user_id' => 'required|exists:users,id',
            'amount_paid' => 'required|numeric|min=0',
            'status' => 'required|in:pending,paid,partial',
        ]);

        // Update bill payment
        $billPayment->update($request->all());

        return response()->json([
            'message' => 'Bill payment updated successfully',
            'billPayment' => $billPayment,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $billPayment = BillPayment::find($id);

        if (!$billPayment) {
            return response()->json(['message' => 'Bill payment not found'], 404);
        }

        $billPayment->delete();

        return response()->json(['message' => 'Bill payment deleted successfully']);
    }
}
