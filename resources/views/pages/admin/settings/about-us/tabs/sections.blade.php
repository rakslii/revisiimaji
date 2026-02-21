<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Page Sections</h2>
        <button onclick="openModal('sectionModal')"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
            <i class="fas fa-plus mr-2"></i>Add Section
        </button>
    </div>
    
    @if($sections->count() > 0)
        <div class="sections-list space-y-4">
            @foreach($sections as $section)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50" data-id="{{ $section->id }}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-4">
                            <div class="cursor-move text-gray-400 hover:text-gray-600 mt-1">
                                <i class="fas fa-grip-vertical"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2 flex-wrap gap-2">
                                    <h3 class="font-medium text-gray-900">{{ $section->title }}</h3>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $section->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $section->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        {{ $section->section_label }}
                                    </span>
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                        Order: {{ $section->order }}
                                    </span>
                                </div>
                                
                                @if($section->subtitle)
                                    <p class="text-sm text-gray-600 mb-2">{{ $section->subtitle }}</p>
                                @endif
                                
                                @if($section->content)
                                    <div class="text-sm text-gray-500 line-clamp-2">
                                        {!! Str::limit(strip_tags($section->content), 150) !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex space-x-2">
                            <button onclick='editSection(@json($section))'
                                    class="text-green-600 hover:text-green-800 p-2">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <form action="{{ route('admin.settings.about-us.sections.toggle-status', $section->id) }}" 
                                  method="POST" 
                                  class="inline">
                                @csrf
                                <button type="submit" 
                                        class="text-{{ $section->is_active ? 'red' : 'green' }}-600 hover:text-{{ $section->is_active ? 'red' : 'green' }}-800 p-2">
                                    <i class="fas fa-power-off"></i>
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.settings.about-us.sections.destroy', $section->id) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this section?')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 p-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="inline-block p-4 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-layer-group text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Sections Found</h3>
            <p class="text-gray-500 mb-6">Add sections to build your about us page</p>
            <button onclick="openModal('sectionModal')"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center mx-auto">
                <i class="fas fa-plus mr-2"></i>Add First Section
            </button>
        </div>
    @endif
</div>