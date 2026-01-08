@extends('pages.admin.layouts.app')

@section('title', $product->name)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">{{ $product->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded mb-3" 
                             style="max-height: 300px;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                             style="height: 300px;">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    @endif
                    
                    <h4>{{ $product->name }}</h4>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-{{ $product->is_active ? 'success' : 'danger' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @if($product->category)
                            <span class="badge bg-info">{{ $product->category->name }}</span>
                        @endif
                    </div>
                    
                    <div class="row text-start">
                        <div class="col-6">
                            <small class="text-muted d-block">Product ID</small>
                            <strong>#{{ $product->id }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Stock</small>
                            <strong class="text-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                {{ $product->stock }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Product Stats</h6>
                </div>
                <div class="card-body">
                    @include('pages.admin.components.stats-card', [
                        'title' => 'Sales Count',
                        'value' => $product->sales_count,
                        'icon' => 'fas fa-shopping-cart',
                        'color' => 'primary',
                        'small' => true
                    ])
                    
                    @include('pages.admin.components.stats-card', [
                        'title' => 'Rating',
                        'value' => $product->rating ?? 'N/A',
                        'icon' => 'fas fa-star',
                        'color' => 'warning',
                        'small' => true
                    ])
                    
                    @include('pages.admin.components.stats-card', [
                        'title' => 'Minimum Order',
                        'value' => $product->min_order,
                        'icon' => 'fas fa-box',
                        'color' => 'info',
                        'small' => true
                    ])
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Product Details</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Price</small>
                            <h4 class="mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                            @if($product->discount_percent > 0)
                                <div class="text-success">
                                    <small>
                                        <s class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</s>
                                        <span class="ms-2">-{{ $product->discount_percent }}%</span>
                                    </small>
                                    <div class="fw-bold">Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Category</small>
                            <div class="d-flex align-items-center">
                              <span class="badge bg-info">{{ $product->category_name }}</span>
                            </div>
                        </div>
                    </div>

                    @if($product->short_description)
                    <div class="mb-3">
                        <small class="text-muted d-block">Short Description</small>
                        <p class="mb-0">{{ $product->short_description }}</p>
                    </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted d-block">Description</small>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    @if($product->specifications && count($product->specifications) > 0)
                    <div class="mb-3">
                        <small class="text-muted d-block">Specifications</small>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    @foreach($product->specifications as $key => $value)
                                    <tr>
                                        <th width="30%">{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                        <td>{{ $value }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Created At</small>
                            <p class="mb-0">{{ $product->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Last Updated</small>
                            <p class="mb-0">{{ $product->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Product Actions</h6>
                    <div>
                        <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Product
                        </a>
                        <button type="button" 
                                class="btn btn-danger" 
                                onclick="showDeleteModal({{ $product->id }})">
                            <i class="fas fa-trash"></i> Delete Product
                        </button>
                        <form id="deleteForm" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pages.admin.components.alert')
@include('pages.admin.components.modal', [
    'id' => 'deleteModal',
    'title' => 'Confirm Delete',
    'body' => 'Are you sure you want to delete "' . $product->name . '"? This action cannot be undone.',
    'actionBtn' => 'Delete',
    'actionColor' => 'danger',
    'formId' => 'deleteForm'
])
@endsection