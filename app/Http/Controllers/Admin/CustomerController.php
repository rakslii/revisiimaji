<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomersExport;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
                return redirect()->route('admin.login')
                    ->with('error', 'Please login first.');
            }
            
            if (auth()->user()->role !== 'admin') {
                auth()->logout();
                return redirect()->route('admin.login')
                    ->with('error', 'Admin access only.');
            }
            
            return $next($request);
        });
    }

    /**
     * Display a listing of customers.
     */
    public function index()
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
    public function show($id)
    {
        $customer = User::with(['orders' => function($query) {
            $query->latest()->limit(10);
        }, 'locations'])
            ->withCount('orders')
            ->findOrFail($id);

        // Calculate total spent
        $totalSpent = Order::where('user_id', $id)
            ->where('status', 'completed')
            ->sum('total');

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
            $customerData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => 'customer',
            ];
            
            // Tambahkan status jika kolom ada
            if (Schema::hasColumn('users', 'status')) {
                $customerData['status'] = 'active';
            }

            $customer = User::create($customerData);

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

        try {
            DB::beginTransaction();

            // Gunakan soft delete jika ada
            if (method_exists($customer, 'delete') && in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($customer))) {
                $customer->delete(); // Soft delete
            } else {
                // Hard delete with related data
                if ($customer->locations()->exists()) {
                    $customer->locations()->delete();
                }
                
                if ($customer->orders()->exists()) {
                    $customer->orders()->delete();
                }
                
                $customer->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete customer: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update customer status (AJAX).
     */
    public function updateStatus(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        try {
            // Cek apakah kolom status ada
            if (!Schema::hasColumn('users', 'status')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status column does not exist in database.',
                ], 400);
            }

            $customer->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Customer status updated successfully.',
                'new_status' => $request->status,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ============ EXPORT METHODS ============

    /**
     * Export customers as CSV
     */
    public function exportCsv(Request $request)
    {
        try {
            $query = User::withCount('orders')
                ->with('orders', 'locations')
                ->where('role', 'customer');
            
            // Apply filters if any
            if ($request->has('status') && $request->status) {
                if (Schema::hasColumn('users', 'status')) {
                    $query->where('status', $request->status);
                }
            }
            
            if ($request->has('period')) {
                if ($request->period === 'this_month') {
                    $query->whereMonth('created_at', now()->month);
                } elseif ($request->period === 'this_week') {
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                } elseif ($request->period === 'today') {
                    $query->whereDate('created_at', now()->today());
                }
            }
            
            $customers = $query->get();
            
            return Excel::download(
                new CustomersExport($customers), 
                'customers_' . date('Y-m-d_His') . '.csv', 
                \Maatwebsite\Excel\Excel::CSV
            );
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to export CSV: ' . $e->getMessage());
        }
    }
    
    /**
     * Export customers as Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $query = User::withCount('orders')
                ->with('orders', 'locations')
                ->where('role', 'customer');
            
            // Apply filters
            if ($request->has('status') && $request->status) {
                if (Schema::hasColumn('users', 'status')) {
                    $query->where('status', $request->status);
                }
            }
            
            if ($request->has('period')) {
                if ($request->period === 'this_month') {
                    $query->whereMonth('created_at', now()->month);
                }
            }
            
            $customers = $query->get();
            
            return Excel::download(
                new CustomersExport($customers), 
                'customers_' . date('Y-m-d_His') . '.xlsx'
            );
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to export Excel: ' . $e->getMessage());
        }
    }
    
    /**
     * Export customers as PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $query = User::withCount('orders')
                ->with('orders')
                ->where('role', 'customer');
            
            // Apply filters
            if ($request->has('status') && $request->status) {
                if (Schema::hasColumn('users', 'status')) {
                    $query->where('status', $request->status);
                }
            }
            
            $customers = $query->get();
            
            $pdf = Pdf::loadView('pages.admin.customers.export-pdf', compact('customers'));
            
            return $pdf->download('customers_' . date('Y-m-d_His') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to export PDF: ' . $e->getMessage());
        }
    }
    
    /**
     * Export selected customers
     */
    public function exportSelected(Request $request)
    {
        try {
            $request->validate([
                'selected_ids' => 'required|array',
                'selected_ids.*' => 'exists:users,id'
            ]);
            
            $customers = User::withCount('orders')
                ->with('orders', 'locations')
                ->where('role', 'customer')
                ->whereIn('id', $request->selected_ids)
                ->get();
            
            return Excel::download(
                new CustomersExport($customers, true), 
                'selected_customers_' . date('Y-m-d_His') . '.csv', 
                \Maatwebsite\Excel\Excel::CSV
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export selected customers: ' . $e->getMessage()
            ], 500);
        }
    }
}