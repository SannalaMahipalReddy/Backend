<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Display a listing of the messages in a room.
     */
    public function index(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        $messages = Message::where('room_id', $request->room_id)->get();
        return response()->json($messages);
    }

    /**
     * Store a newly created message in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'message' => 'required|string',
            'receiver_id' => 'nullable|exists:users,id', // Optional receiver_id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Store the message
        $message = new Message();
        $message->room_id = $request->room_id;
        $message->sender_id = auth()->user()->id; // Set the sender as the authenticated user
        $message->receiver_id = $request->receiver_id; // Can be null for group messages
        $message->message = $request->message;
        $message->save();

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message,
        ]);
    }

    /**
     * Display the specified message.
     */
    public function show($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        return response()->json($message);
    }

    /**
     * Update the specified message in storage.
     */
    public function update(Request $request, $id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        // Validate the input
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'nullable|exists:users,id', // Optional receiver_id
        ]);

        // Update the message content
        $message->message = $request->message;
        $message->receiver_id = $request->receiver_id; // Update receiver if necessary
        $message->save();

        return response()->json([
            'message' => 'Message updated successfully',
            'data' => $message,
        ]);
    }

    /**
     * Remove the specified message from storage.
     */
    public function destroy($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        $message->delete();

        return response()->json(['message' => 'Message deleted successfully']);
    }
}
