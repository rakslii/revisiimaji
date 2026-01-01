<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Location Management</h1>
        <p class="text-gray-600 mt-1">Kelola lokasi pengiriman</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coordinates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Validated</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <template x-for="location in locations" :key="location.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900" x-text="location.orderId"></td>
                            <td class="px-6 py-4 text-sm text-gray-600" x-text="location.user"></td>
                            <td class="px-6 py-4 text-sm text-gray-600" x-text="location.address"></td>
                            <td class="px-6 py-4 text-sm text-gray-600" x-text="`${location.lat}, ${location.lng}`"></td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                      :class="location.validated ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'"
                                      x-text="location.validated ? 'Validated' : 'Pending'"></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded" 
                                            title="View on Map"
                                            @click="openGoogleMaps(location.lat, location.lng)">
                                        <i class="fas fa-map-marker-alt w-5 h-5"></i>
                                    </button>
                                    <template x-if="!location.validated">
                                        <button class="p-2 text-green-600 hover:bg-green-50 rounded" title="Validate">
                                            <i class="fas fa-check-circle w-5 h-5"></i>
                                        </button>
                                    </template>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>