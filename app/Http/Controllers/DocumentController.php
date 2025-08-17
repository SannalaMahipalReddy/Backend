<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::all();
        return response()->json($documents);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This method can be used if you want to show a form for document creation, but not needed for API.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the file upload
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Allowed file types and size limit
            'room_id' => 'required|exists:rooms,id',
        ]);

        // Store the file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            // Save document details in the database
            $document = new Document();
            $document->room_id = $request->room_id;
            $document->uploaded_by = auth()->user()->id;  // Ensure user authentication is working here
            $document->file_name = $fileName;
            $document->file_path = '/storage/' . $filePath;
            $document->save();

            return response()->json([
                'message' => 'File uploaded successfully',
                'document' => $document,
            ]);
        }

        return response()->json(['message' => 'File upload failed'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = Document::find($id);

        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        return response()->json($document);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Not needed for API, usually used for web-based forms.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $document = Document::find($id);

        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        $request->validate([
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Optional file validation
            'room_id' => 'required|exists:rooms,id',
        ]);

        // Update file if uploaded
        if ($request->hasFile('file')) {
            // Delete old file
            Storage::disk('public')->delete(str_replace('/storage/', '', $document->file_path));

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');
            $document->file_name = $fileName;
            $document->file_path = '/storage/' . $filePath;
        }

        $document->room_id = $request->room_id;
        $document->save();

        return response()->json([
            'message' => 'Document updated successfully',
            'document' => $document,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Document::find($id);

        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        // Delete the file from storage
        Storage::disk('public')->delete(str_replace('/storage/', '', $document->file_path));

        $document->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }
}
