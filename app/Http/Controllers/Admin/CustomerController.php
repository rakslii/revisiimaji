<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function customers()
    {
        $customers = User::withCount('orders')
            ->where('role', 'customer')
            ->latest()
            ->paginate(10);

        return view('pages.admin.customers.index', compact('customers'));
    }

    /**
     * Display customer details.
     */
    public function customerDetail($id)
    {
        $customer = User::with(['orders' => function($query) {
            $query->latest()->limit(10);
        }, 'locations'])
            ->withCount('orders')
            ->findOrFail($id);

        // FIX: Gunakan kolom yang benar berdasarkan struktur database
        // Coba beberapa kemungkinan nama kolom
        $totalSpent = 0;
        
        try {
            // Coba cek kolom yang tersedia di database
            $orderColumns = DB::getSchemaBuilder()->getColumnListing('orders');
            
            if (in_array('total_amount', $orderColumns)) {
                $totalSpent = Order::where('user_id', $id)
                    ->where('status', 'completed')
                    ->sum('total_amount');
            } 
            // Jika tidak ada total_amount, coba kolom lain
            elseif (in_array('total', $orderColumns)) {
                $totalSpent = Order::where('user_id', $id)
                    ->where('status', 'completed')
                    ->sum('total');
            }
            elseif (in_array('final_amount', $orderColumns)) {
                $totalSpent = Order::where('user_id', $id)
                    ->where('status', 'completed')
                    ->sum('final_amount');
            }
            // Default jika tidak ada kolom total
            else {
                // Hitung manual dari order items
                $completedOrders = Order::where('user_id', $id)
                    ->where('status', 'completed')
                    ->with('items')
                    ->get();
                
                foreach ($completedOrders as $order) {
                    foreach ($order->items as $item) {
                        $totalSpent += ($item->price * $item->quantity);
                    }
                }
            }
        } catch (\Exception $e) {
            // Jika ada error, set ke 0
            $totalSpent = 0;
        }

        $avgOrderValue = $customer->orders_count > 0 
            ? $totalSpent / $customer->orders_count 
            : 0;

        return view('pages.admin.customers.show', compact('customer', 'totalSpent', 'avgOrderValue'));
    }

    /**
     * Show create customer form.
     */
    public function create()
    {
        return view('pages.admin.customers.create');
    }

    /**
     * Store a new customer.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $customer = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => 'customer',
            ]);

            return redirect()->route('admin.customers.show', $customer->id)
                ->with('success', 'Customer created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create customer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show edit customer form.
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('pages.admin.customers.edit', compact('customer'));
    }

    /**
     * Update customer.
     */
    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $customer->update($updateData);

            return redirect()->route('admin.customers.show', $customer->id)
                ->with('success', 'Customer updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update customer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete customer.
     */
    public function destroy($id)
    {
        $customer = User::findOrFail($id);

        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete customer with existing orders. Consider deactivating instead.');
        }

        try {
            DB::beginTransaction();

            // Delete customer's locations
            $customer->locations()->delete();

            // Delete customer
            $customer->delete();

            DB::commit();

            return redirect()->route('admin.customers')
                ->with('success', 'Customer deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to delete customer: ' . $e->getMessage());
        }
    }

    /**
     * Update customer status.
     */
    public function updateStatus(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $customer->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Customer status updated successfully.',
        ]);
    }
}