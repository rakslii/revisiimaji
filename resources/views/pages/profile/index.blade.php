@extends('layouts.app')

@section('title', 'Profil Pengguna - Cipta Imaji')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Profil Saya</h1>
                <p class="text-gray-600 mt-2">Kelola informasi profil dan alamat pengiriman Anda</p>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-green-700">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Profile Info -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <!-- Profile Photo -->
                        <div class="text-center mb-6">
                            <div class="relative inline-block">
                                <img src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=3B82F6&background=DBEAFE' }}"
                                    alt="{{ $user->name }}"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg mx-auto">
                                @if ($user->google_id)
                                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2">
                                        <span
                                            class="bg-blue-100 text-blue-600 text-xs font-semibold px-3 py-1 rounded-full">
                                            <i class="fab fa-google mr-1"></i> Google
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <h2 class="text-xl font-bold text-gray-800 mt-4">{{ $user->name }}</h2>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </div>

                        <!-- Account Info -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">ID Member</span>
                                <span
                                    class="font-semibold text-blue-600">#{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Bergabung</span>
                                <span class="font-semibold">
                                    {{ optional($user->created_at)->translatedFormat('d F Y') ?? '-' }}
                                </span>

                            </div>
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Total Alamat</span>
                                <span class="font-semibold">{{ $locations->count() }}</span>
                            </div>
                            @if ($user->google_id)
                                <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                                    <div class="flex items-center">
                                        <i class="fab fa-google text-blue-500 text-lg mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-blue-700">Akun Google Terhubung</p>
                                            <p class="text-sm text-blue-600 mt-1">Login dengan: {{ $user->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Forms -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Update Profile Form -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-user-edit text-blue-500 mr-3"></i>
                            Informasi Profil
                        </h3>

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap *
                                    </label>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        required>
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email *
                                    </label>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        required>
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon
                                    </label>
                                    <input type="text" id="phone" name="phone"
                                        value="{{ old('phone', $user->phone) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        placeholder="0812-3456-7890">
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Display Primary Address if exists -->
                                @if ($primaryAddress)
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Alamat Utama
                                        </label>
                                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                            <p class="font-medium">{{ $primaryAddress->name }}</p>
                                            <p class="text-gray-600 text-sm mt-1">{{ $primaryAddress->full_address }}</p>
                                            <p class="text-gray-500 text-sm mt-1">{{ $primaryAddress->city }},
                                                {{ $primaryAddress->province }} {{ $primaryAddress->postal_code }}</p>
                                            <p class="text-gray-500 text-sm mt-1">Penerima:
                                                {{ $primaryAddress->recipient_name }}
                                                ({{ $primaryAddress->recipient_phone }})</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-8 flex justify-end">
                                <button type="submit"
                                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Address Management -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-map-marker-alt text-blue-500 mr-3"></i>
                                Daftar Alamat Pengiriman
                            </h3>
                            <button type="button" onclick="openAddressModal()"
                                class="mt-4 sm:mt-0 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors inline-flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Alamat Baru
                            </button>
                        </div>

                        <!-- Address List -->
                        @if ($locations->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($locations as $location)
                                    <div
                                        class="border border-gray-200 rounded-xl p-5 hover:border-blue-300 transition-colors {{ $location->is_primary ? 'border-blue-300 bg-blue-50' : '' }}">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex items-center">
                                                <h4 class="font-bold text-gray-800">{{ $location->name }}</h4>
                                                @if ($location->is_primary)
                                                    <span
                                                        class="ml-3 px-3 py-1 bg-blue-100 text-blue-600 text-xs font-semibold rounded-full">
                                                        Utama
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                <button type="button" onclick="editAddress({{ $location->id }})"
                                                    class="w-8 h-8 flex items-center justify-center text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST"
                                                    action="{{ route('profile.locations.delete', $location) }}"
                                                    onsubmit="return confirm('Hapus alamat ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-8 h-8 flex items-center justify-center text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="space-y-2">
                                            <div class="flex items-start">
                                                <i class="fas fa-user text-gray-400 mt-1 mr-3"></i>
                                                <div>
                                                    <p class="text-sm text-gray-600">Penerima</p>
                                                    <p class="font-medium">{{ $location->recipient_name }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-start">
                                                <i class="fas fa-phone text-gray-400 mt-1 mr-3"></i>
                                                <div>
                                                    <p class="text-sm text-gray-600">Telepon</p>
                                                    <p class="font-medium">{{ $location->recipient_phone }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-start">
                                                <i class="fas fa-map-marker-alt text-gray-400 mt-1 mr-3"></i>
                                                <div>
                                                    <p class="text-sm text-gray-600">Alamat</p>
                                                    <p class="font-medium">{{ $location->full_address }}</p>
                                                    <p class="text-gray-600 text-sm mt-1">
                                                        {{ $location->city }}, {{ $location->province }}
                                                        {{ $location->postal_code }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        @if (!$location->is_primary)
                                            <div class="mt-4 pt-4 border-t border-gray-100">
                                                <form method="POST"
                                                    action="{{ route('profile.locations.setPrimary', $location) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center">
                                                        <i class="fas fa-star mr-2"></i>
                                                        Jadikan alamat utama
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-12">
                                <div
                                    class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-map-marker-alt text-gray-400 text-3xl"></i>
                                </div>
                                <h4 class="text-xl font-semibold text-gray-700 mb-2">Belum ada alamat</h4>
                                <p class="text-gray-500 max-w-md mx-auto mb-6">
                                    Tambahkan alamat pengiriman untuk mempermudah proses pembelian Anda.
                                </p>
                                <button type="button" onclick="openAddressModal()"
                                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors inline-flex items-center">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Alamat Pertama
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Modal -->
    <div id="addressModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeAddressModal()"></div>

            <!-- Modal content -->
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="POST" action="{{ route('profile.locations.store') }}" id="addressForm">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="location_id" id="locationId">

                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-800" id="modalTitle">
                                Tambah Alamat Baru
                            </h3>
                            <button type="button" onclick="closeAddressModal()"
                                class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times text-2xl"></i>
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="address_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Alamat *
                                </label>
                                <input type="text" id="address_name" name="name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Contoh: Rumah, Kantor, Apartemen" required>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Penerima *
                                    </label>
                                    <input type="text" id="recipient_name" name="recipient_name"
                                        value="{{ $user->name }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        required>
                                </div>
                                <div>
                                    <label for="recipient_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Telepon Penerima *
                                    </label>
                                    <input type="text" id="recipient_phone" name="recipient_phone"
                                        value="{{ $user->phone ?? '' }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        required>
                                </div>
                            </div>

                            <div>
                                <label for="full_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Lengkap *
                                </label>
                                <textarea id="full_address" name="full_address" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Jalan, nomor rumah, RT/RW, kelurahan" required></textarea>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kota *
                                    </label>
                                    <input type="text" id="city" name="city"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        required>
                                </div>
                                <div>
                                    <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                                        Provinsi *
                                    </label>
                                    <input type="text" id="province" name="province"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        required>
                                </div>
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kode Pos *
                                    </label>
                                    <input type="text" id="postal_code" name="postal_code"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                                        Latitude
                                    </label>
                                    <input type="number" step="0.000001" id="latitude" name="latitude"
                                        value="-6.2088"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        required>
                                </div>
                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                                        Longitude
                                    </label>
                                    <input type="number" step="0.000001" id="longitude" name="longitude"
                                        value="106.8456"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        required>
                                </div>
                            </div>

                            <div class="flex items-center pt-2">
                                <input type="checkbox" id="is_primary" name="is_primary" value="1"
                                    class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                                <label for="is_primary" class="ml-3 text-sm text-gray-700">
                                    Jadikan sebagai alamat utama
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse rounded-b-2xl">
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3">
                            Simpan Alamat
                        </button>
                        <button type="button" onclick="closeAddressModal()"
                            class="mt-3 sm:mt-0 w-full sm:w-auto px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Address Modal Functions
        function openAddressModal() {
            document.getElementById('addressModal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = 'Tambah Alamat Baru';
            document.getElementById('addressForm').action = "{{ route('profile.locations.store') }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('locationId').value = '';

            // Reset form
            document.getElementById('addressForm').reset();
            document.getElementById('recipient_name').value = "{{ $user->name }}";
            document.getElementById('recipient_phone').value = "{{ $user->phone ?? '' }}";

            document.body.classList.add('overflow-hidden');
        }

        function editAddress(locationId) {
            // Fetch location data via AJAX
            fetch(`/profile/locations/${locationId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('addressModal').classList.remove('hidden');
                    document.getElementById('modalTitle').textContent = 'Edit Alamat';
                    document.getElementById('addressForm').action = `/profile/locations/${locationId}`;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('locationId').value = locationId;

                    // Fill form with data
                    document.getElementById('address_name').value = data.name;
                    document.getElementById('recipient_name').value = data.recipient_name;
                    document.getElementById('recipient_phone').value = data.recipient_phone;
                    document.getElementById('full_address').value = data.full_address;
                    document.getElementById('city').value = data.city;
                    document.getElementById('province').value = data.province;
                    document.getElementById('postal_code').value = data.postal_code;
                    document.getElementById('latitude').value = data.latitude;
                    document.getElementById('longitude').value = data.longitude;
                    document.getElementById('is_primary').checked = data.is_primary;

                    document.body.classList.add('overflow-hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengambil data alamat');
                });
        }

        function closeAddressModal() {
            document.getElementById('addressModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAddressModal();
            }
        });

        // Auto-fill address for Google users
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-fill for new addresses if user has phone number
            const userPhone = "{{ $user->phone ?? '' }}";
            if (userPhone) {
                document.getElementById('recipient_phone').value = userPhone;
            }
        });
    </script>
@endpush
