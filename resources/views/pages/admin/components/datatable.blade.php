@props(['headers' => [], 'data' => []])

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
        @forelse($data as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $item->order_code ?? $item->id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $item->user->name ?? 'Guest' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    Rp {{ number_format($item->total_amount ?? $item->total_price ?? 0, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $item->status == 'paid' ? 'bg-green-100 text-green-800' : 
                           ($item->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($item->status ?? 'pending') }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $item->created_at->format('d M Y') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($headers) }}" class="px-6 py-4 text-center text-gray-500">
                    No data available
                </td>
            </tr>
        @endforelse
    </tbody>
</table>