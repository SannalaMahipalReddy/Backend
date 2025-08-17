<?php

namespace App\Http\Controllers;

use App\Models\RoomUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomusers = RoomUser::all();
        return response()->json($roomusers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create a new RoomUser entry
        $roomuser = RoomUser::create($request->all());

        return response()->json($roomuser, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roomuser = RoomUser::find($id);
        if (!$roomuser) {
            return response()->json(['message' => 'RoomUser not found'], 404);
        }
        return response()->json($roomuser);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'room_id' => 'sometimes|exists:rooms,id',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $roomuser = RoomUser::find($id);
        if (!$roomuser) {
            return response()->json(['message' => 'RoomUser not found'], 404);
        }

        // Update the RoomUser entry
        $roomuser->update($request->all());

        return response()->json($roomuser);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roomuser = RoomUser::find($id);
        if (!$roomuser) {
            return response()->json(['message' => 'RoomUser not found'], 404);
        }

        $roomuser->delete();
        return response()->json(['message' => 'RoomUser deleted successfully']);
    }
}
