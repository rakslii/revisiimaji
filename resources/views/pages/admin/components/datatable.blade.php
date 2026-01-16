@if(empty($data))
    <div class="p-6 text-center text-gray-500">
        No data available
    </div>
@else
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                @foreach($headers as $header)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($data as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        #{{ $item['order_code'] ?? $item['id'] ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $item['customer_name'] ?? 'N/A' }}
                        @if(isset($item['customer_email']))
                            <div class="text-xs text-gray-500">{{ $item['customer_email'] }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $item['formatted_total'] ?? 'Rp ' . number_format($item['total'] ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'shipped' => 'bg-purple-100 text-purple-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $status = $item['status'] ?? 'pending';
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $item['created_at'] ?? 'N/A' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif