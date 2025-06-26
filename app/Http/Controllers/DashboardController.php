<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShortUrl;
use App\Models\Company;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('filter', 'all');

        // Base query for URLs
        $query = ShortUrl::with('user');

        // Role-based filtering
        if ($user->role === 'Admin') {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('company_id', $user->company_id);
            });
        } elseif ($user->role === 'Member') {
            $query->where('user_id', $user->id);
        }

        // Time filter
        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()]);
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month);
                break;
            case 'all':
            default:
                break;
        }
        $urls = $query->latest()->get();

        // Fetch companies only for SuperAdmin
        $companies = $user->role === 'SuperAdmin'
            ? Company::with('users.shortUrls')->get()
            : [];

        return view('dashboard', compact('user', 'urls', 'companies'));
    }
}
