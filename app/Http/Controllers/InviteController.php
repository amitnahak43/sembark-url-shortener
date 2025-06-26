<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    /**
     * Show the invitation form
     */
    public function create()
    {
        return view('invite');
    }

    /**
     * Handle storing of invited user
     */
    public function store(Request $request)
    {
        $request->merge([
            'role' => trim($request->role),
        ]);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|in:Admin,Member',
        ]);

        $inviter = Auth::user();

        if ($inviter->role === 'SuperAdmin') {
            $companyName = $request->name . "'s Company";
            $company = Company::firstOrCreate(['name' => $companyName]);
        } else {
            $company = $inviter->company;
        }
        
        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'role'       => $request->role,
            'password'   => Hash::make('default123'),
            'company_id' => $company->id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Invitation sent.');
    }
}
