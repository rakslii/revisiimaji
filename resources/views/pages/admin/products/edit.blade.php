@extends('pages.admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Edit Product: {{ $product->name }}</h1>
                <div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> View
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $product->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number"
                                               class="form-control @error('price') is-invalid @enderror"
                                               id="price"
                                               name="price"
                                               value="{{ old('price', $product->price) }}"
                                               min="0"
                                               step="1000"
                                               required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount_percent" class="form-label">Discount (%)</label>
                                    <input type="number"
                                           class="form-control @error('discount_percent') is-invalid @enderror"
                                           id="discount_percent"
                                           name="discount_percent"
                                           value="{{ old('discount_percent', $product->discount_percent) }}"
                                           min="0"
                                           max="100">
                                    @error('discount_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category *</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                            id="category_id"
                                            name="category_id"
                                            required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                                {{ $category->name }} ({{ $category->type }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock *</label>
                                    <input type="number"
                                           class="form-control @error('stock') is-invalid @enderror"
                                           id="stock"
                                           name="stock"
                                           value="{{ old('stock', $product->stock) }}"
                                           min="0"
                                           required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <input type="text"
                                   class="form-control @error('short_description') is-invalid @enderror"
                                   id="short_description"
                                   name="short_description"
                                   value="{{ old('short_description', $product->short_description) }}"
                                   maxlength="255">
                            <small class="form-text text-muted">Max 255 characters</small>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Full Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="min_order" class="form-label">Minimum Order</label>
                                    <input type="number"
                                           class="form-control @error('min_order') is-invalid @enderror"
                                           id="min_order"
                                           name="min_order"
                                           value="{{ old('min_order', $product->min_order) }}"
                                           min="1">
                                    @error('min_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Product Image</label>
                                    <input type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           id="image"
                                           name="image"
                                           accept="image/*">
                                    @if($product->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 width="100"
                                                 class="rounded border">
                                            <small class="d-block text-muted">Current image</small>
                                        </div>
                                    @endif
                                    <small class="form-text text-muted">Leave empty to keep current image</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-check-label">
                                <input type="checkbox"
                                       class="form-check-input"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                Active Product
                            </label>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-secondary me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @include('pages.admin.components.stats-card', [
                'title' => 'Product Stats',
                'value' => $product->sales_count . ' sales',
                'icon' => 'fas fa-chart-line',
                'color' => 'info',
                'description' => 'Created: ' . $product->created_at->format('d M Y')
            ])

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        <button type="button"
                                class="btn btn-outline-danger"
                                onclick="showDeleteModal({{ $product->id }})">
                            <i class="fas fa-trash"></i> Delete Product
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            @include('pages.admin.components.modal', [
                'id' => 'deleteModal',
                'title' => 'Confirm Delete',
                'body' => 'Are you sure you want to delete this product? This action cannot be undone.',
                'actionBtn' => 'Delete',
                'actionColor' => 'danger',
                'formId' => 'deleteForm',
                'method' => 'DELETE'
            ])
        </div>
    </div>
</div>

@include('pages.admin.components.alert')

@push('scripts')
<script>
function showDeleteModal(productId) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/products/${productId}`;

    // Use the modal component
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
@endsection
