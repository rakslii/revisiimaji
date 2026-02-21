<!DOCTYPE html>
<html>
<head>
    <title>Customers Export</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #4CAF50; color: white; padding: 10px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .date { color: #666; font-size: 12px; text-align: right; }
        .status-active { color: green; }
        .status-inactive { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Customers Data Export</h2>
        <p>Total Customers: {{ $customers->count() }}</p>
        <div class="date">Exported on: {{ now()->format('d M Y H:i:s') }}</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                @if(\Illuminate\Support\Facades\Schema::hasColumn('users', 'status'))
                <th>Status</th>
                @endif
                <th>Orders</th>
                <th>Total Spent</th>
                <th>Joined Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            @php
                $totalSpent = $customer->orders()->where('status', 'completed')->sum('total');
            @endphp
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone ?? 'N/A' }}</td>
                
                @if(\Illuminate\Support\Facades\Schema::hasColumn('users', 'status'))
                <td class="status-{{ $customer->status ?? 'active' }}">
                    {{ ucfirst($customer->status ?? 'active') }}
                </td>
                @endif
                
                <td>{{ $customer->orders_count ?? 0 }}</td>
                <td>Rp {{ number_format($totalSpent, 0, ',', '.') }}</td>
                <td>{{ $customer->created_at ? $customer->created_at->format('d M Y') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>