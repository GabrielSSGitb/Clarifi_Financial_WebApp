<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);


        $user = auth()->user();


        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update([
            'avatar' => $path
        ]);

        // 5. Retorna a resposta JSON contendo a URL pública para o JavaScript injetar na view
        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $path)
        ]);
    }
}
