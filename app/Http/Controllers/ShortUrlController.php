<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Auth;

class ShortUrlController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'SuperAdmin') {
            abort(403, 'SuperAdmin cannot create short URLs.');
        }

        $request->validate([
            'original_url' => 'required|url'
        ]);

        $shortCode = Str::random(6);

        ShortUrl::create([
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
            'user_id' => $user->id,
            'hits' => 0
        ]);

        return redirect()->back()->with('success', 'Short URL generated.');
    }

    public function resolve($short_code)
    {
        $url = ShortUrl::where('short_code', $short_code)->firstOrFail();
        $url->increment('hits');
        return redirect($url->original_url);
    }
}
