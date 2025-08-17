<?php

namespace App\Http\Controllers;

use App\Models\VacancyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VacancyNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vacancies = VacancyNotification::all();
        return response()->json($vacancies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'message' => 'required|string',
            'vacancy_status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create a new VacancyNotification entry
        $vacancy = VacancyNotification::create($request->all());

        return response()->json($vacancy, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vacancy = VacancyNotification::find($id);
        if (!$vacancy) {
            return response()->json(['message' => 'Vacancy notification not found'], 404);
        }
        return response()->json($vacancy);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'room_id' => 'sometimes|exists:rooms,id',
            'message' => 'sometimes|string',
            'vacancy_status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $vacancy = VacancyNotification::find($id);
        if (!$vacancy) {
            return response()->json(['message' => 'Vacancy notification not found'], 404);
        }

        // Update the VacancyNotification entry
        $vacancy->update($request->all());

        return response()->json($vacancy);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vacancy = VacancyNotification::find($id);
        if (!$vacancy) {
            return response()->json(['message' => 'Vacancy notification not found'], 404);
        }

        $vacancy->delete();
        return response()->json(['message' => 'Vacancy notification deleted successfully']);
    }
}
