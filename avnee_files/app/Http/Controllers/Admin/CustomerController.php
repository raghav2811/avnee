<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('is_blocked', $request->status === 'blocked');
        }

        $customers = $query->latest()
            ->withCount('orders')
            ->paginate(15)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Display the specified customer.
     */
    public function show(User $user)
    {
        if ($user->role !== 'customer') {
            abort(404);
        }

        $user->load(['orders' => function($q) {
            $q->latest();
        }]);

        $totalSpend = $user->orders()->where('payment_status', 'paid')->sum('total_amount');

        return view('admin.customers.show', compact('user', 'totalSpend'));
    }

    /**
     * Toggle block status for a customer.
     */
    public function toggleBlock(User $user)
    {
        if ($user->role !== 'customer') {
            return redirect()->back()->with('error', 'Cannot block non-customer users.');
        }

        $user->update([
            'is_blocked' => !$user->is_blocked
        ]);

        $status = $user->is_blocked ? 'blocked' : 'unblocked';
        return redirect()->back()->with('success', "Customer has been {$status} successfully.");
    }
}
