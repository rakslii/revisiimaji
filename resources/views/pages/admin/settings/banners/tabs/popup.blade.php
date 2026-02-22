<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Popup Banners</h3>
        <a href="{{ route('admin.settings.banners.create') }}?type=popup" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm flex items-center">
            <i class="fas fa-plus mr-2"></i>Add Popup
        </a>
    </div>

    @if($popups->isEmpty())
    <div class="text-center py-12">
        <div class="inline-block p-6 bg-gray-50 rounded-2xl">
            <i class="fas fa-window-restore text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">No popups yet</p>
            <p class="text-sm text-gray-400 mt-2">Click "Add Popup" to create your first popup banner</p>
        </div>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 50px">Drag</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 100px">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position/Size</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delay</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 banners-list">
                @foreach($popups->sortBy('display_order') as $popup)
                <tr data-id="{{ $popup->id }}" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <i class="fas fa-grip-vertical text-gray-400 cursor-move handle"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                            @if($popup->image_url)
                                <img src="{{ $popup->image_url }}" 
                                     alt="{{ $popup->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $popup->title ?? '-' }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($popup->description, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">
                            {{ ucfirst($popup->position) }} / {{ ucfirst($popup->size) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm text-gray-600">{{ $popup->delay_seconds }} seconds</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap status-badge">
                        {!! $popup->status_badge !!}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <button onclick="toggleStatus({{ $popup->id }}, this)" 
                                    class="text-gray-600 hover:text-gray-900" title="Toggle Status">
                                @if($popup->is_active)
                                    <i class="fas fa-toggle-on text-green-600 text-xl"></i>
                                @else
                                    <i class="fas fa-toggle-off text-gray-400 text-xl"></i>
                                @endif
                            </button>
                            <a href="{{ route('admin.settings.banners.edit', $popup->id) }}" 
                               class="text-blue-600 hover:text-blue-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteBanner({{ $popup->id }}, '{{ addslashes($popup->title ?? 'Untitled') }}')" 
                                    class="text-red-600 hover:text-red-900" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>