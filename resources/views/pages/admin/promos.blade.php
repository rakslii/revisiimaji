<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Promo Code Management</h1>
            <p class="text-gray-600 mt-1">Kelola kode promo</p>
        </div>
        <button class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus w-5 h-5"></i>
            Create Promo
        </button>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usage</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expiry</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <template x-for="promo in promoCodes" :key="promo.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900" x-text="promo.code"></td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                      :class="promo.type === 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'"
                                      x-text="promo.type"></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <template x-if="promo.type === 'percentage'">
                                    <span x-text="`${promo.value}%`"></span>
                                </template>
                                <template x-if="promo.type === 'nominal'">
                                    <span x-text="`Rp ${formatCurrency(promo.value)}`"></span>
                                </template>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600" x-text="`${promo.used} / ${promo.quota}`"></td>
                            <td class="px-6 py-4 text-sm text-gray-600" x-text="promo.expiry"></td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                      :class="promo.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                      x-text="promo.status"></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded" title="Edit">
                                        <i class="fas fa-edit w-5 h-5"></i>
                                    </button>
                                    <button class="p-2 text-red-600 hover:bg-red-50 rounded" title="Delete">
                                        <i class="fas fa-trash-alt w-5 h-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>