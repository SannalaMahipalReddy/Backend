<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the bills.
     */
    public function index()
    {
        $bills = Bill::all();
        return response()->json($bills);
    }

    /**
     * Store a newly created bill in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'created_by' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'category' => 'required|in:rent,utilities,groceries,miscellaneous',
            'total_amount' => 'required|numeric|min:0',
            'split_method' => 'required|in:equally,percentage',
            'is_recurring' => 'boolean',
            'due_date' => 'required|date'
        ]);

        $bill = Bill::create($validatedData);

        return response()->json($bill, 201);
    }

    /**
     * Display the specified bill.
     */
    public function show(string $id)
    {
        $bill = Bill::find($id);
        if (!$bill) {
            return response()->json(['message' => 'Bill not found'], 404);
        }
        return response()->json($bill);
    }

    /**
     * Update the specified bill in storage.
     */
    public function update(Request $request, string $id)
    {
        $bill = Bill::find($id);
        if (!$bill) {
            return response()->json(['message' => 'Bill not found'], 404);
        }

        $validatedData = $request->validate([
            'room_id' => 'sometimes|exists:rooms,id',
            'created_by' => 'sometimes|exists:users,id',
            'title' => 'sometimes|string|max:255',
            'category' => 'sometimes|in:rent,utilities,groceries,miscellaneous',
            'total_amount' => 'sometimes|numeric|min:0',
            'split_method' => 'sometimes|in:equally,percentage',
            'is_recurring' => 'boolean',
            'due_date' => 'sometimes|date'
        ]);

        $bill->update($validatedData);

        return response()->json($bill);
    }

    /**
     * Remove the specified bill from storage.
     */
    public function destroy(string $id)
    {
        $bill = Bill::find($id);
        if (!$bill) {
            return response()->json(['message' => 'Bill not found'], 404);
        }

        $bill->delete();
        return response()->json(['message' => 'Bill deleted successfully']);
    }
}
