<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Achievements & Stats</h2>
        <button onclick="openModal('achievementModal')"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
            <i class="fas fa-plus mr-2"></i>Add Achievement
        </button>
    </div>
    
    @if($achievements->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($achievements as $achievement)
                <div class="border border-gray-200 rounded-lg p-6 hover:bg-gray-50 text-center">
                    @if($achievement->icon)
                        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mx-auto mb-4">
                            <i class="{{ $achievement->icon }} text-blue-600 text-xl"></i>
                        </div>
                    @endif
                    
                    <div class="text-3xl font-bold text-gray-900 mb-2">
                        {{ $achievement->display_value }}
                    </div>
                    
                    <h3 class="font-medium text-gray-900 mb-2">{{ $achievement->title }}</h3>
                    
                    @if($achievement->description)
                        <p class="text-sm text-gray-600 mb-4">{{ $achievement->description }}</p>
                    @endif
                    
                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-xs text-gray-400">Order: {{ $achievement->order }}</span>
                        <div class="flex space-x-2">
                            <button onclick='editAchievement(@json($achievement))'
                                    class="text-green-600 hover:text-green-800">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <form action="{{ route('admin.settings.about-us.achievements.destroy', $achievement->id) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Delete this achievement?')">
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
                <i class="fas fa-trophy text-gray-400 text-4xl"></i>
            </div>
            <p class="text-gray-500 mb-6">Add achievements and stats to highlight on your about us page</p>
            <button onclick="openModal('achievementModal')"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center mx-auto">
                <i class="fas fa-plus mr-2"></i>Add Achievement
            </button>
        </div>
    @endif
</div>