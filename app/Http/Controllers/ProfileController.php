<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // GET /api/profiles
    public function index()
    {
        return response()->json(
            Profile::whereNull('archived_at')->orderByDesc('id')->get(),
            200
        );
    }

    // POST /api/profiles
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required','string','max:255'],
            'last_name'  => ['nullable','string','max:255'],
            'email'      => ['required','email','max:255', Rule::unique('profiles','email')->withoutTrashed()],
        ]);

        $profile = Profile::create($data);
        return response()->json($profile, 201);
    }

    // PUT /api/profiles/{profile}
    public function update(Request $request, Profile $profile)
    {
        $data = $request->validate([
            'first_name' => ['required','string','max:255'],
            'last_name'  => ['nullable','string','max:255'],
            'email'      => ['required','email','max:255', Rule::unique('profiles','email')->ignore($profile->id)->withoutTrashed()],
        ]);

        $profile->update($data);
        return response()->json($profile, 200);
    }

    // DELETE /api/profiles/{profile}
    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response()->noContent();
    }

    // POST /api/profiles/{profile}/archive
    public function archive(Profile $profile)
    {
        $profile->archived_at = now();
        $profile->save();
        return response()->json($profile, 200);
    }

    // POST /api/profiles/{profile}/unarchive
    public function unarchive(Profile $profile)
    {
        $profile->archived_at = null;
        $profile->save();
        return response()->json($profile, 200);
    }

    // GET /api/profiles/archived
    public function archived()
    {
        return response()->json(
            Profile::whereNotNull('archived_at')->orderByDesc('id')->get(),
            200
        );
    }
}

