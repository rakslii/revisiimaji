@extends('pages.admin.layouts.app')

@section('title', 'About Us Management')

@section('content')
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

    <!-- Stats Cards -->
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
            @include('pages.admin.settings.about-us.tabs.sections')
        @elseif($tab == 'team')
            @include('pages.admin.settings.about-us.tabs.team')
        @elseif($tab == 'achievements')
            @include('pages.admin.settings.about-us.tabs.achievements')
        @elseif($tab == 'values')
            @include('pages.admin.settings.about-us.tabs.values')
        @endif
    </div>
</div>

<!-- Modals -->
@include('pages.admin.settings.about-us.modals.section')
@include('pages.admin.settings.about-us.modals.team')
@include('pages.admin.settings.about-us.modals.achievement')
@include('pages.admin.settings.about-us.modals.value')

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
        document.body.style.overflow = 'hidden';
    } else {
        console.error('Modal not found:', modalId);
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
    resetForms();
}

function resetForms() {
    // Reset all forms
    document.querySelectorAll('form[id^="form-"]').forEach(form => {
        form.reset();
    });
    
    // Reset method to POST
    document.querySelectorAll('input[name="_method"]').forEach(input => {
        if (input) input.value = 'POST';
    });
    
    // Reset submit buttons
    document.querySelectorAll('button[type="submit"]').forEach(button => {
        if (button && button.closest('form') && button.closest('form').id) {
            const formId = button.closest('form').id;
            if (formId === 'form-section') {
                button.innerHTML = '<i class="fas fa-plus mr-2"></i>Add Section';
            } else if (formId === 'form-team') {
                button.innerHTML = '<i class="fas fa-plus mr-2"></i>Add Team Member';
            } else if (formId === 'form-achievement') {
                button.innerHTML = '<i class="fas fa-plus mr-2"></i>Add Achievement';
            } else if (formId === 'form-value') {
                button.innerHTML = '<i class="fas fa-plus mr-2"></i>Add Core Value';
            }
        }
    });
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fixed') && event.target.classList.contains('bg-gray-600')) {
        document.querySelectorAll('.fixed.inset-0.bg-gray-600').forEach(modal => {
            modal.classList.add('hidden');
        });
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
        document.getElementById('section_title').value = section.title || '';
        document.getElementById('section_subtitle').value = section.subtitle || '';
        document.getElementById('section_content').value = section.content || '';
        document.getElementById('section_type').value = section.section_type || '';
        document.getElementById('section_position').value = section.position || 'main';
        document.getElementById('section_order').value = section.order || 0;
        document.getElementById('section_is_active').checked = section.is_active || false;
        
        // Change form action for update
        const route = '{{ route("admin.settings.about-us.sections.update", ":id") }}'.replace(':id', section.id);
        form.action = route;
        
        // Set method to PUT
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.value = 'PUT';
        
        // Update button text
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Update Section';
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
        document.getElementById('team_order').value = member.order || 0;
        document.getElementById('team_is_active').checked = member.is_active || false;
        
        // Social links
        const socialLinks = member.social_links || {};
        document.getElementById('team_social_linkedin').value = socialLinks.linkedin || '';
        document.getElementById('team_social_instagram').value = socialLinks.instagram || '';
        document.getElementById('team_social_twitter').value = socialLinks.twitter || '';
        
        // Change form action for update
        const route = '{{ route("admin.settings.about-us.team-members.update", ":id") }}'.replace(':id', member.id);
        form.action = route;
        
        // Set method to PUT (note: using POST with _method PUT for file upload)
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.value = 'PUT';
        
        // Update button text
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Update Team Member';
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
        
        // Change form action for update
        const route = '{{ route("admin.settings.about-us.achievements.update", ":id") }}'.replace(':id', achievement.id);
        form.action = route;
        
        // Set method to PUT
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.value = 'PUT';
        
        // Update button text
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Update Achievement';
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
        document.getElementById('value_order').value = value.order || 0;
        document.getElementById('value_is_active').checked = value.is_active || false;
        
        // Change form action for update
        const route = '{{ route("admin.settings.about-us.core-values.update", ":id") }}'.replace(':id', value.id);
        form.action = route;
        
        // Set method to PUT
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.value = 'PUT';
        
        // Update button text
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Update Core Value';
        }
        
        openModal('valueModal');
    } catch (error) {
        console.error('Error in editCoreValue:', error);
    }
}

// Initialize drag and drop for sections
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.sections-list');
    if (container && typeof Sortable !== 'undefined') {
        new Sortable(container, {
            animation: 150,
            handle: '.cursor-move',
            onEnd: function(evt) {
                const items = Array.from(container.children);
                const orderData = items.map((item, index) => {
                    const id = item.getAttribute('data-id');
                    return { id: id, order: index };
                }).filter(item => item.id);
                
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
                        // Show success message or reload
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