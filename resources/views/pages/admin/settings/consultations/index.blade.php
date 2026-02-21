@extends('pages.admin.layouts.app')

@section('title', 'Consultation Settings')
@section('page-title', 'Consultation Settings')
@section('page-description', 'Manage WhatsApp consultation links')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

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
                    <span class="text-blue-600 font-medium">Consultations</span>
                </li>
            </ol>
        </nav>
        
        <h1 class="text-2xl font-bold text-gray-900">Consultation Settings</h1>
        <p class="text-gray-600 mt-1">Configure WhatsApp consultation links</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="mb-6 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="consultationTabs">
            <li class="mr-2">
                <a href="#general" 
                   class="inline-block p-4 rounded-t-lg tab-link active"
                   data-tab="general">
                    <i class="fas fa-globe mr-2"></i>General Consultation
                </a>
            </li>
            <li class="mr-2">
                <a href="#product" 
                   class="inline-block p-4 rounded-t-lg tab-link"
                   data-tab="product">
                    <i class="fas fa-box mr-2"></i>Product Consultation
                </a>
            </li>
            <li class="mr-2">
                <a href="#custom" 
                   class="inline-block p-4 rounded-t-lg tab-link"
                   data-tab="custom">
                    <i class="fas fa-paint-brush mr-2"></i>Custom Products
                </a>
            </li>
        </ul>
    </div>

    <!-- Tab Contents -->
    <div class="tab-contents">
        <!-- General Consultation Tab -->
        <div id="general" class="tab-content active">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">General Consultation Settings</h3>
                    <p class="text-sm text-gray-600">Used in navbar, footer, and CTA sections</p>
                </div>
                
                <form action="{{ route('admin.settings.consultations.general.update', $general->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="text" 
                                   name="phone_number" 
                                   value="{{ old('phone_number', $general->phone_number) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="6281234567890">
                            <p class="text-xs text-gray-500 mt-1">Format: 628xxx (gunakan kode negara 62)</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Display Text *</label>
                            <input type="text" 
                                   name="display_text" 
                                   value="{{ old('display_text', $general->display_text) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Chat WhatsApp">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message Template</label>
                        <textarea name="message_template" 
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Halo, saya ingin konsultasi. Bisa dibantu?">{{ old('message_template', $general->message_template) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Gunakan [NAME] untuk nama customer (opsional)</p>
                    </div>
                    
                    <div class="flex items-center mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ $general->is_active ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Active</span>
                        </label>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Consultation Tab -->
        <div id="product" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Product Consultation Settings</h3>
                    <p class="text-sm text-gray-600">Used in product pages - same for all products</p>
                </div>
                
                <form action="{{ route('admin.settings.consultations.product.update', $product->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="text" 
                                   name="phone_number" 
                                   value="{{ old('phone_number', $product->phone_number) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="6281234567890">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Display Text *</label>
                            <input type="text" 
                                   name="display_text" 
                                   value="{{ old('display_text', $product->display_text) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Konsultasi via WhatsApp">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message Template</label>
                        <textarea name="message_template" 
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Halo, saya tertarik dengan produk *[PRODUCT_NAME]*. Bisa info lebih lanjut?">{{ old('message_template', $product->message_template) }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">
                            <span class="font-semibold">Available variables:</span><br>
                            <code>[PRODUCT_NAME]</code> - Nama produk<br>
                            <code>[CUSTOMER_NAME]</code> - Nama customer (jika login)<br>
                            <code>[PRODUCT_URL]</code> - Akan otomatis ditambahkan jika opsi di bawah diaktifkan
                        </p>
                    </div>
                    
                    <div class="mb-6 space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="include_product_url" 
                                   value="1"
                                   {{ $product->include_product_url ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Include product URL in message</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ $product->is_active ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Active</span>
                        </label>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Custom Product Consultation Tab -->
        <div id="custom" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Custom Product Consultation Settings</h3>
                    <p class="text-sm text-gray-600">Used in custom product pages</p>
                </div>
                
                <form action="{{ route('admin.settings.consultations.custom.update', $custom->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="text" 
                                   name="phone_number" 
                                   value="{{ old('phone_number', $custom->phone_number) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="6281234567890">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Display Text *</label>
                            <input type="text" 
                                   name="display_text" 
                                   value="{{ old('display_text', $custom->display_text) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Konsultasi Produk Custom">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message Template</label>
                        <textarea name="message_template" 
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Halo, saya ingin konsultasi tentang produk custom *[PRODUCT_NAME]*. Bisa dibantu?">{{ old('message_template', $custom->message_template) }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">
                            <span class="font-semibold">Available variables:</span><br>
                            <code>[PRODUCT_NAME]</code> - Nama produk custom<br>
                            <code>[CUSTOMER_NAME]</code> - Nama customer (jika login)
                        </p>
                    </div>
                    
                    <div class="flex items-center mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ $custom->is_active ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Active</span>
                        </label>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Preview WhatsApp Links -->
<div class="mt-8 bg-gray-50 rounded-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview Links</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg border">
            <div class="text-sm font-medium text-gray-700 mb-2">General Consultation</div>
            <a href="{{ $general->getWhatsAppUrl() }}" target="_blank" 
               class="text-green-600 hover:text-green-800 flex items-center">
                <i class="fab fa-whatsapp mr-2"></i>
                {{ $general->display_text }}
            </a>
        </div>
        
        <div class="bg-white p-4 rounded-lg border">
            <div class="text-sm font-medium text-gray-700 mb-2">Product Consultation</div>
            <a href="{{ $product->getWhatsAppUrl(new \App\Models\Product()) }}" target="_blank" 
               class="text-green-600 hover:text-green-800 flex items-center">
                <i class="fab fa-whatsapp mr-2"></i>
                {{ $product->display_text }}
            </a>
            <p class="text-xs text-gray-500 mt-2">Contoh dengan produk dummy</p>
        </div>
        
        <div class="bg-white p-4 rounded-lg border">
            <div class="text-sm font-medium text-gray-700 mb-2">Custom Consultation</div>
            <a href="{{ $custom->getWhatsAppUrl('Contoh Produk Custom') }}" target="_blank" 
               class="text-green-600 hover:text-green-800 flex items-center">
                <i class="fab fa-whatsapp mr-2"></i>
                {{ $custom->display_text }}
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tab switching
    document.querySelectorAll('.tab-link').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Get tab id
            const tabId = link.getAttribute('href').substring(1);
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab-link').forEach(l => {
                l.classList.remove('active', 'text-blue-600', 'border-b-2', 'border-blue-600');
                l.classList.add('text-gray-500');
            });
            
            // Add active class to clicked tab
            link.classList.add('active', 'text-blue-600', 'border-b-2', 'border-blue-600');
            link.classList.remove('text-gray-500');
            
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show selected tab content
            document.getElementById(tabId).classList.remove('hidden');
        });
    });
</script>
@endpush