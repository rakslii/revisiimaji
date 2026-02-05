@extends('pages.admin.layouts.app')

@section('title', 'About Us Management')

@section('content')
@php
    // Pastikan semua key ada dengan null coalescing
    $sections = $data['sections'] ?? collect();
    $teamMembers = $data['teamMembers'] ?? collect();
    $achievements = $data['achievements'] ?? collect();
    $values = $data['values'] ?? collect();
    
    // Pastikan semua route ada
    if (!Route::has('admin.settings.about-us.sections.toggle-status')) {
        \Log::warning('Route admin.settings.about-us.sections.toggle-status not found');
    }
@endphp

<div class="container mx-auto px-4 py-6">
    <!-- Header dengan Breadcrumb -->
    <div class="mb-6">
        <nav class="flex mb-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                </li>
                <li class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('admin.settings.index') }}" class="text-gray-700 hover:text-blue-600">
                        Settings
                    </a>
                </li>
                <li aria-current="page" class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-blue-600 font-medium">About Us</span>
                </li>
            </ol>
        </nav>
        
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">About Us Management</h1>
                <p class="text-gray-600 mt-1">Manage your about us page sections and content</p>
            </div>
            
            <div class="flex space-x-2">
                <!-- Preview Button -->
                <a href="{{ route('about-us') }}" 
                   target="_blank"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
                    <i class="fas fa-eye mr-2"></i>Preview Page
                </a>
                
                <!-- Quick Add Menu -->
                <div class="relative group">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                        <i class="fas fa-plus mr-2"></i>Add New
                        <i class="fas fa-chevron-down ml-2"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-10 hidden group-hover:block">
                        <a href="#" 
                           onclick="openModal('sectionModal')"
                           class="block px-4 py-3 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-layer-group mr-2"></i>Add Section
                        </a>
                        <a href="#" 
                           onclick="openModal('teamModal')"
                           class="block px-4 py-3 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-users mr-2"></i>Add Team Member
                        </a>
                        <a href="#" 
                           onclick="openModal('achievementModal')"
                           class="block px-4 py-3 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-trophy mr-2"></i>Add Achievement
                        </a>
                        <a href="#" 
                           onclick="openModal('valueModal')"
                           class="block px-4 py-3 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-star mr-2"></i>Add Core Value
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="border-b">
            <nav class="flex -mb-px">
                <a href="{{ route('admin.settings.about-us.index', ['tab' => 'sections']) }}" 
                   class="py-4 px-6 font-medium text-sm border-b-2 {{ ($tab == 'sections') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-layer-group mr-2"></i>Sections
                    <span class="ml-1 bg-gray-200 text-gray-800 text-xs px-2 py-0.5 rounded-full">{{ $sections->count() }}</span>
                </a>
                <a href="{{ route('admin.settings.about-us.index', ['tab' => 'team']) }}" 
                   class="py-4 px-6 font-medium text-sm border-b-2 {{ ($tab == 'team') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-users mr-2"></i>Team Members
                    <span class="ml-1 bg-gray-200 text-gray-800 text-xs px-2 py-0.5 rounded-full">{{ $teamMembers->count() }}</span>
                </a>
                <a href="{{ route('admin.settings.about-us.index', ['tab' => 'achievements']) }}" 
                   class="py-4 px-6 font-medium text-sm border-b-2 {{ ($tab == 'achievements') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-trophy mr-2"></i>Achievements
                    <span class="ml-1 bg-gray-200 text-gray-800 text-xs px-2 py-0.5 rounded-full">{{ $achievements->count() }}</span>
                </a>
                <a href="{{ route('admin.settings.about-us.index', ['tab' => 'values']) }}" 
                   class="py-4 px-6 font-medium text-sm border-b-2 {{ ($tab == 'values') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-star mr-2"></i>Core Values
                    <span class="ml-1 bg-gray-200 text-gray-800 text-xs px-2 py-0.5 rounded-full">{{ $values->count() }}</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-3 mr-4">
                    <i class="fas fa-layer-group text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Sections</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $sections->where('is_active', true)->count() }}/{{ $sections->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="rounded-lg bg-green-100 p-3 mr-4">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Team Members</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $teamMembers->where('is_active', true)->count() }}/{{ $teamMembers->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="rounded-lg bg-purple-100 p-3 mr-4">
                    <i class="fas fa-trophy text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Achievements</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $achievements->where('is_active', true)->count() }}/{{ $achievements->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="rounded-lg bg-yellow-100 p-3 mr-4">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Core Values</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $values->where('is_active', true)->count() }}/{{ $values->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content based on Tab -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($tab == 'sections')
            <!-- Sections Tab -->
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Page Sections</h2>
                    <button onclick="openModal('sectionModal')"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                        <i class="fas fa-plus mr-2"></i>Add Section
                    </button>
                </div>
                
                @if($sections->count() > 0)
                    <div class="space-y-4">
                        @foreach($sections as $section)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <div class="cursor-move text-gray-400 hover:text-gray-600 mt-1">
                                            <i class="fas fa-grip-vertical"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center space-x-2 mb-2">
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
                                        <button onclick="editSection({{ json_encode($section) }})"
                                                class="text-green-600 hover:text-green-800 p-2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if(Route::has('admin.settings.about-us.sections.toggle-status'))
                                        <form action="{{ route('admin.settings.about-us.sections.toggle-status', $section->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-{{ $section->is_active ? 'red' : 'green' }}-600 hover:text-{{ $section->is_active ? 'red' : 'green' }}-800 p-2">
                                                <i class="fas fa-power-off"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @if(Route::has('admin.settings.about-us.sections.destroy'))
                                        <form action="{{ route('admin.settings.about-us.sections.destroy', $section->id) }}" 
                                              method="POST"
                                              onsubmit="return confirm('Delete this section?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 p-2">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
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
            
        @elseif($tab == 'team')
            <!-- Team Members Tab -->
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
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <!-- Header with Gradient -->
                                <div class="h-20 relative" style="background: linear-gradient(135deg, {{ $member->gradient_colors['from'] ?? '#193497' }}, {{ $member->gradient_colors['to'] ?? '#1e40af' }});">
                                    <div class="absolute top-3 right-3">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $member->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Body -->
                                <div class="p-4 pt-0">
                                    <!-- Avatar -->
                                    <div class="w-16 h-16 rounded-xl mx-auto -mt-8 mb-4 flex items-center justify-center text-white font-bold text-xl"
                                         style="background: linear-gradient(135deg, {{ $member->gradient_colors['from'] ?? '#193497' }}, {{ $member->gradient_colors['to'] ?? '#1e40af' }});">
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
                                        @if($member->social_links)
                                            <div class="flex justify-center space-x-3 mb-4">
                                                @foreach($member->social_links as $platform => $link)
                                                    @if($link)
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
                                                <button onclick="editTeamMember({{ json_encode($member) }})"
                                                        class="text-green-600 hover:text-green-800">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @if(Route::has('admin.settings.about-us.team-members.destroy'))
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
                                                @endif
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
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Team Members</h3>
                        <p class="text-gray-500 mb-6">Add your team members to showcase on the about us page</p>
                        <button onclick="openModal('teamModal')"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center mx-auto">
                            <i class="fas fa-plus mr-2"></i>Add Team Member
                        </button>
                    </div>
                @endif
            </div>
            
        @elseif($tab == 'achievements')
            <!-- Achievements Tab -->
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
                                        <button onclick="editAchievement({{ json_encode($achievement) }})"
                                                class="text-green-600 hover:text-green-800">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if(Route::has('admin.settings.about-us.achievements.destroy'))
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
                                        @endif
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
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Achievements</h3>
                        <p class="text-gray-500 mb-6">Add achievements and stats to highlight on your about us page</p>
                        <button onclick="openModal('achievementModal')"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center mx-auto">
                            <i class="fas fa-plus mr-2"></i>Add Achievement
                        </button>
                    </div>
                @endif
            </div>
            
        @elseif($tab == 'values')
            <!-- Core Values Tab -->
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
                                     style="background: linear-gradient(135deg, {{ $value->gradient_colors['from'] ?? '#193497' }}, {{ $value->gradient_colors['to'] ?? '#1e40af' }});">
                                    <i class="{{ $value->icon }} text-white text-xl"></i>
                                </div>
                                
                                <h3 class="font-bold text-gray-900 mb-3">{{ $value->title }}</h3>
                                <p class="text-sm text-gray-600 mb-4">{{ $value->description }}</p>
                                
                                <div class="flex justify-between items-center pt-4 border-t">
                                    <span class="text-xs text-gray-400">Order: {{ $value->order }}</span>
                                    <div class="flex space-x-2">
                                        <button onclick="editCoreValue({{ json_encode($value) }})"
                                                class="text-green-600 hover:text-green-800">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if(Route::has('admin.settings.about-us.core-values.destroy'))
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
                                        @endif
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
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Core Values</h3>
                        <p class="text-gray-500 mb-6">Add core values that represent your company culture</p>
                        <button onclick="openModal('valueModal')"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center mx-auto">
                            <i class="fas fa-plus mr-2"></i>Add Core Value
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Modals -->
@includeIf('pages.admin.settings.about-us.modals.section')
@includeIf('pages.admin.settings.about-us.modals.team')
@includeIf('pages.admin.settings.about-us.modals.achievement')
@includeIf('pages.admin.settings.about-us.modals.value')

@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
// Modal Functions
let currentEditId = null;

function openModal(modalId) {
    currentEditId = null;
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    } else {
        console.error('Modal not found:', modalId);
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Restore scrolling
    }
    resetForms();
}

function resetForms() {
    // Reset all forms
    document.querySelectorAll('form').forEach(form => {
        if (form.id && form.id.startsWith('form-')) {
            form.reset();
        }
    });
    
    // Clear hidden input values
    document.querySelectorAll('input[name="_method"]').forEach(input => {
        if (input) input.value = 'POST';
    });
    
    // Reset submit buttons
    document.querySelectorAll('button[type="submit"]').forEach(button => {
        if (button && button.closest('form') && button.closest('form').id.startsWith('form-')) {
            button.textContent = 'Add';
            const icon = button.querySelector('i');
            if (icon) icon.className = 'fas fa-plus mr-2';
        }
    });
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fixed') && event.target.classList.contains('bg-gray-600')) {
        event.target.classList.add('hidden');
        document.body.style.overflow = '';
    }
});

// Section Functions
function editSection(section) {
    try {
        currentEditId = section.id;
        const form = document.getElementById('form-section');
        
        if (!form) {
            console.error('Form not found: form-section');
            return;
        }
        
        // Populate form
        const titleInput = document.getElementById('section_title');
        const subtitleInput = document.getElementById('section_subtitle');
        const contentInput = document.getElementById('section_content');
        const typeInput = document.getElementById('section_type');
        const positionInput = document.getElementById('section_position');
        const orderInput = document.getElementById('section_order');
        const bgColorInput = document.getElementById('section_background_color');
        const textColorInput = document.getElementById('section_text_color');
        const iconInput = document.getElementById('section_icon');
        const isActiveInput = document.getElementById('section_is_active');
        
        if (titleInput) titleInput.value = section.title || '';
        if (subtitleInput) subtitleInput.value = section.subtitle || '';
        if (contentInput) contentInput.value = section.content || '';
        if (typeInput) typeInput.value = section.section_type || '';
        if (positionInput) positionInput.value = section.position || 'main';
        if (orderInput) orderInput.value = section.order || 0;
        if (bgColorInput) bgColorInput.value = section.background_color || '';
        if (textColorInput) textColorInput.value = section.text_color || '';
        if (iconInput) iconInput.value = section.icon || '';
        if (isActiveInput) isActiveInput.checked = section.is_active || false;
        
        // Change form action
        const route = '{{ route("admin.settings.about-us.sections.update", ":id") }}'.replace(':id', section.id);
        form.action = route;
        
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.value = 'PUT';
        
        // Update button
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.textContent = 'Update Section';
            const icon = submitBtn.querySelector('i');
            if (icon) icon.className = 'fas fa-save mr-2';
        }
        
        openModal('sectionModal');
    } catch (error) {
        console.error('Error in editSection:', error);
    }
}

// Team Member Functions
function editTeamMember(member) {
    try {
        currentEditId = member.id;
        const form = document.getElementById('form-team');
        
        if (!form) {
            console.error('Form not found: form-team');
            return;
        }
        
        // Populate form
        document.getElementById('team_name').value = member.name || '';
        document.getElementById('team_position').value = member.position || '';
        document.getElementById('team_bio').value = member.bio || '';
        document.getElementById('team_initial').value = member.initial || '';
        document.getElementById('team_color_scheme').value = member.color_scheme || '';
        document.getElementById('team_order').value = member.order || 0;
        document.getElementById('team_is_active').checked = member.is_active || false;
        
        // Social links
        const socialLinks = member.social_links || {};
        document.getElementById('team_social_linkedin').value = socialLinks.linkedin || '';
        document.getElementById('team_social_instagram').value = socialLinks.instagram || '';
        document.getElementById('team_social_twitter').value = socialLinks.twitter || '';
        
        // Change form action
        const route = '{{ route("admin.settings.about-us.team-members.update", ":id") }}'.replace(':id', member.id);
        form.action = route;
        
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.value = 'PUT';
        
        // Update button
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.textContent = 'Update Team Member';
            const icon = submitBtn.querySelector('i');
            if (icon) icon.className = 'fas fa-save mr-2';
        }
        
        openModal('teamModal');
    } catch (error) {
        console.error('Error in editTeamMember:', error);
    }
}

// Achievement Functions
function editAchievement(achievement) {
    try {
        currentEditId = achievement.id;
        const form = document.getElementById('form-achievement');
        
        if (!form) {
            console.error('Form not found: form-achievement');
            return;
        }
        
        // Populate form
        document.getElementById('achievement_title').value = achievement.title || '';
        document.getElementById('achievement_icon').value = achievement.icon || '';
        document.getElementById('achievement_value').value = achievement.value || '';
        document.getElementById('achievement_suffix').value = achievement.suffix || '';
        document.getElementById('achievement_description').value = achievement.description || '';
        document.getElementById('achievement_order').value = achievement.order || 0;
        document.getElementById('achievement_is_active').checked = achievement.is_active || false;
        
        // Change form action
        const route = '{{ route("admin.settings.about-us.achievements.update", ":id") }}'.replace(':id', achievement.id);
        form.action = route;
        
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.value = 'PUT';
        
        // Update button
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.textContent = 'Update Achievement';
            const icon = submitBtn.querySelector('i');
            if (icon) icon.className = 'fas fa-save mr-2';
        }
        
        openModal('achievementModal');
    } catch (error) {
        console.error('Error in editAchievement:', error);
    }
}

// Core Value Functions
function editCoreValue(value) {
    try {
        currentEditId = value.id;
        const form = document.getElementById('form-value');
        
        if (!form) {
            console.error('Form not found: form-value');
            return;
        }
        
        // Populate form
        document.getElementById('value_title').value = value.title || '';
        document.getElementById('value_description').value = value.description || '';
        document.getElementById('value_icon').value = value.icon || '';
        document.getElementById('value_color_scheme').value = value.color_scheme || '';
        document.getElementById('value_order').value = value.order || 0;
        document.getElementById('value_is_active').checked = value.is_active || false;
        
        // Change form action
        const route = '{{ route("admin.settings.about-us.core-values.update", ":id") }}'.replace(':id', value.id);
        form.action = route;
        
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.value = 'PUT';
        
        // Update button
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.textContent = 'Update Core Value';
            const icon = submitBtn.querySelector('i');
            if (icon) icon.className = 'fas fa-save mr-2';
        }
        
        openModal('valueModal');
    } catch (error) {
        console.error('Error in editCoreValue:', error);
    }
}

// Initialize drag and drop hanya jika ada container
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.space-y-4');
    if (container && typeof Sortable !== 'undefined') {
        new Sortable(container, {
            animation: 150,
            handle: '.cursor-move',
            onEnd: function(evt) {
                const items = Array.from(container.querySelectorAll('[data-id]'));
                const orderData = items.map((item, index) => ({
                    id: item.dataset.id,
                    order: index
                }));
                
                // Cek route ada
                @if(Route::has('admin.settings.about-us.sections.reorder'))
                fetch('{{ route("admin.settings.about-us.sections.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ sections: orderData })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Error reordering:', error));
                @endif
            }
        });
    }
});
</script>
@endpush