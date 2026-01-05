@props(['id', 'title'])

<div id="{{ $id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-lg font-semibold">{{ $title }}</h3>
                <button onclick="document.getElementById('{{ $id }}').classList.add('hidden')" 
                        class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                {{ $slot ?? '' }} <!-- ⚡ TAMBAH null coalescing -->
            </div>
            
            <!-- Footer -->
            @if(!empty($slot))
            <div class="p-6 border-t flex justify-end space-x-3">
                <button onclick="document.getElementById('{{ $id }}').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" form="{{ $id }}-form"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Save
                </button>
            </div>
            @endif
        </div>
    </div>
</div>