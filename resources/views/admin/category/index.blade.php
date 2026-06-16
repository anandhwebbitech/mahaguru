@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    
    {{-- Alerts Message Box --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-dark fw-bold"><i class="fa-solid fa-layer-group me-2 text-primary"></i> Category List</h5>
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Add Category
            </a>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="categoryTable">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 10%">S.No</th>
                            <th style="width: 20%">Image</th>
                            <th style="width: 45%">Category Name</th>
                            <th class="text-center" style="width: 25%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $cat)
                            <tr>
                                <td class="ps-4 fw-medium text-secondary">{{ $loop->iteration }}</td>
                                <td>
                                    @if($cat->image && file_exists(public_path('uploads/categories/' . $cat->image)))
                                        <img src="{{ asset('public/uploads/categories/' . $cat->image) }}" 
                                             alt="{{ $cat->name }}" 
                                             class="rounded shadow-sm border" 
                                             style="width: 60px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light text-secondary rounded d-flex align-items-center justify-content-center border" style="width: 60px; height: 50px; font-size: 12px;">
                                            No Image
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $cat->name }}</span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.category.edit', $cat->id) }}"
                                           class="btn btn-outline-warning btn-sm px-3">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                        </a>

                                        {{-- DELETE OPTION WITH CONFIRMATION --}}
                                        <form action="{{ route('admin.category.destroy', $cat->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this category? All related content may be affected.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                                                <i class="fa-solid fa-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-secondary">
                                    <i class="fa-solid fa-folder-open display-6 mb-2 d-block text-muted"></i>
                                    No categories available. Click "Add Category" to create one.
                               td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection