<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $activeCustomers = Customer::count();
        
        // Sadece admin silinenleri görebilir
        $deletedCustomers = ($user->role === 'admin') ? Customer::onlyTrashed()->count() : null;
        
        // Admin ve Manager kullanıcıları görebilir
        $users = in_array($user->role, ['admin', 'manager']) ? User::count() : null;

        return view('dashboard', compact('activeCustomers', 'deletedCustomers', 'users'));
    }
}
