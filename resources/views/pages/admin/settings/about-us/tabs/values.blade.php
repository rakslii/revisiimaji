<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Core Values</h2>
        <button onclick="openModal('valueModal')"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
            <i class="fas fa-plus mr-2"></i>Add Core Value
        </button>
    </div>
    
    @if($values->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($values as $value)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4"
                         style="background: linear-gradient(135deg, #193497, #1e40af);">
                        <i class="{{ $value->icon }} text-white text-xl"></i>
                    </div>
                    
                    <h3 class="font-bold text-gray-900 mb-3">{{ $value->title }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $value->description }}</p>
                    
                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-xs text-gray-400">Order: {{ $value->order }}</span>
                        <div class="flex space-x-2">
                            <button onclick='editCoreValue(@json($value))'
                                    class="text-green-600 hover:text-green-800">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <form action="{{ route('admin.settings.about-us.core-values.destroy', $value->id) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Delete this core value?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800">
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
                <i class="fas fa-star text-gray-400 text-4xl"></i>
            </div>
            <p class="text-gray-500 mb-6">Add core values that represent your company culture</p>
            <button onclick="openModal('valueModal')"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center mx-auto">
                <i class="fas fa-plus mr-2"></i>Add Core Value
            </button>
        </div>
    @endif
</div>