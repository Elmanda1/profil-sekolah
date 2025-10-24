<?php

namespace App\Http\Controllers;

use App\Models\Akun; // Assuming Akun model exists
use App\Models\Siswa; // Assuming Siswa model exists for nama siswa and nisn
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response; // Using facade for consistent response
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\AkunResource;

class AkunApiController extends Controller
{
    /**
     * Get details for the authenticated user's account (Akun and related Siswa info).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAkunDetails(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return Response::json([
                'status' => 'error',
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $authenticatedUser = Auth::user();

        $akun = Akun::where('id', $authenticatedUser->id ?? null) // Assuming `id` of authenticated user maps to `Akun`
                    ->orWhere('id_siswa', $authenticatedUser->id ?? null)
                    ->orWhere('id_guru', $authenticatedUser->id ?? null)
                    ->first();

        if (!$akun) {
             return Response::json([
                'status' => 'error',
                'message' => 'Account details not found for the authenticated user.'
            ], 404);
        }

        // Return the AkunResource, which handles loading related Siswa data
        return new AkunResource($akun);
    }

    /**
     * Allows an authenticated user to change their password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {

        $user = Auth::user();

        // Assuming your 'User' model stores the password directly.
        // If 'Akun' is where the password is, you'll need to fetch and update it.
        // For this example, let's assume Auth::user() refers to the entity that holds the password.
        // If 'Akun' holds the password, you'd do something like:
        // $akun = Akun::where('id_siswa', $user->id)->first(); // Or by other identifier
        // if (!$akun || !Hash::check($request->current_password, $akun->password)) { ... }
        // $akun->password = Hash::make($request->new_password);
        // $akun->save();

        if (!Hash::check($request->current_password, $user->password)) {
            return Response::json([
                'status' => 'error',
                'message' => 'The provided current password does not match our records.'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return Response::json([
            'status' => 'success',
            'message' => 'Password updated successfully.'
        ]);
    }
}
