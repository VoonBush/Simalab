<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Item;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_items'       => Item::count(),
            'available_items'   => Item::where('available_stock', '>', 0)->count(),
            'pending_borrowings'=> Borrowing::where('status', 'pending')->count(),
            'active_borrowings' => \App\Models\BorrowingDetail::whereHas('borrowing', function($query) {
                $query->whereIn('status', ['approved', 'borrowed']);
            })->sum('quantity'),
            'total_users'       => User::count(),
            'total_modules'     => Module::where('is_published', true)->count(),
        ];

        $recentBorrowings = Borrowing::with(['user', 'details.item'])
            ->latest()
            ->take(10)
            ->get();

        $pendingBorrowings = Borrowing::with(['user', 'details.item'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBorrowings', 'pendingBorrowings'));
    }

    public function users(Request $request)
    {
        abort_unless(auth()->user()->hasRole(['pj']), 403);

        $users = User::with('roles')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('npm', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15);

        $roles = \Spatie\Permission\Models\Role::all();

        return view('admin.users', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        abort_unless(auth()->user()->hasRole(['pj']), 403);

        $request->validate(['role' => 'required|exists:roles,name']);

        $user->syncRoles([$request->role]);

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$request->role}.");
    }
}
