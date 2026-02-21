<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Team Members</h2>
        <button onclick="openModal('teamModal')"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
            <i class="fas fa-plus mr-2"></i>Add Team Member
        </button>
    </div>
    
    @if($teamMembers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($teamMembers as $member)
                @php
                    // Decode social links jika masih string
                    $socialLinks = $member->social_links;
                    if (is_string($socialLinks)) {
                        $socialLinks = json_decode($socialLinks, true) ?? [];
                    }
                    if (!is_array($socialLinks)) {
                        $socialLinks = [];
                    }
                @endphp
                
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Header with Gradient - FIXED -->
                    <div class="h-20 relative" style="background: linear-gradient(135deg, #193497, #1e40af);">
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 text-xs rounded-full {{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Body -->
                    <div class="p-4 pt-0">
                        <!-- Avatar - FIXED -->
                        <div class="w-16 h-16 rounded-xl mx-auto -mt-8 mb-4 flex items-center justify-center text-white font-bold text-xl"
                             style="background: linear-gradient(135deg, #193497, #1e40af);">
                            @if($member->image_url)
                                <img src="{{ $member->image_url }}" 
                                     alt="{{ $member->name }}"
                                     class="w-full h-full object-cover rounded-xl">
                            @else
                                {{ $member->avatar_initials }}
                            @endif
                        </div>
                        
                        <div class="text-center">
                            <h3 class="font-bold text-gray-900">{{ $member->name }}</h3>
                            <p class="text-sm text-blue-600 mb-3">{{ $member->position }}</p>
                            
                            @if($member->bio)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $member->bio }}</p>
                            @endif
                            
                            <!-- Social Links -->
                            @if(!empty($socialLinks) && is_array($socialLinks))
                                <div class="flex justify-center space-x-3 mb-4">
                                    @foreach($socialLinks as $platform => $link)
                                        @if(!empty($link))
                                            <a href="{{ $link }}" 
                                               target="_blank"
                                               class="text-gray-400 hover:text-blue-600">
                                                <i class="fab fa-{{ $platform }}"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            
                            <!-- Actions -->
                            <div class="flex justify-between items-center pt-4 border-t">
                                <span class="text-xs text-gray-400">Order: {{ $member->order }}</span>
                                <div class="flex space-x-2">
                                    <button onclick='editTeamMember(@json($member))'
                                            class="text-green-600 hover:text-green-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.settings.about-us.team-members.destroy', $member->id) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Delete {{ $member->name }}?')">
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
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="inline-block p-4 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-users text-gray-400 text-4xl"></i>
            </div>
            <p class="text-gray-500 mb-6">Add your team members to showcase on the about us page</p>
            <button onclick="openModal('teamModal')"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center mx-auto">
                <i class="fas fa-plus mr-2"></i>Add Team Member
            </button>
        </div>
    @endif
</div>