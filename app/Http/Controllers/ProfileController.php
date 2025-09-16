<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    // POST /api/submit
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:profiles,email',
            'age' => 'nullable|integer|min:0',
        ]);

        $profile = Profile::create($data);

        return response()->json(['message' => 'Created', 'data' => $profile], 201);
    }

    // GET /api/profilelist
    public function display(): JsonResponse
    {
        $profiles = Profile::orderByDesc('id')->get();
        return response()->json(['data' => $profiles]);
    }

    // PUT /api/profile/{id}
    public function update(Request $request, $id): JsonResponse
    {
        $profile = Profile::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:profiles,email,' . $profile->id,
            'age' => 'nullable|integer|min:0',
        ]);

        $profile->update($data);

        return response()->json(['message' => 'Updated', 'data' => $profile]);
    }

    // DELETE /api/profile/{id}
    public function destroy($id): JsonResponse
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
