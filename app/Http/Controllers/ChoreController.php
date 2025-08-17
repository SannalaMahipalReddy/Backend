<?php

namespace App\Http\Controllers;

use App\Models\Chore;
use Illuminate\Http\Request;

class ChoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chores = Chore::all();
        return response()->json($chores);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'assigned_user_id' => 'nullable|exists:users,id',  // allow nullable
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'required|date',
        'status' => 'required|in:pending,completed',
    ]);

    // Create a new chore
    $chore = Chore::create($request->all());

    return response()->json($chore, 201); // return the created chore
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $chore = Chore::find($id);

        if (!$chore) {
            return response()->json(['message' => 'Chore not found'], 404);
        }

        return response()->json($chore);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $chore = Chore::find($id);

        if (!$chore) {
            return response()->json(['message' => 'Chore not found'], 404);
        }

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'assigned_user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|string|in:pending,completed',
        ]);

        $chore->update($request->all());
        return response()->json($chore);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $chore = Chore::find($id);

        if (!$chore) {
            return response()->json(['message' => 'Chore not found'], 404);
        }

        $chore->delete();
        return response()->json(['message' => 'Chore deleted successfully']);
    }
}
