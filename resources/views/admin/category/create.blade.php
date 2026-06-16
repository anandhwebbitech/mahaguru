@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold"><i class="fa-solid fa-folder-plus me-2 text-success"></i> Create New Category</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Category Name Input --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium text-secondary">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Cotton Materials" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Category Image Input --}}
                        <div class="mb-4">
                            <label for="image" class="form-label fw-medium text-secondary">Category Image</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required onchange="previewImage(this);">
                            <small class="text-muted d-block mt-1">Recommended size: 400x300px (Max 2MB)</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Live Image Preview --}}
                            <div class="mt-3">
                                <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail rounded shadow-sm d-none" style="max-height: 150px; object-fit: cover;">
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2 justify-content-end border-top pt-3">
                            <a href="{{ route('admin.category.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Save Category</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "#";
            preview.classList.add('d-none');
        }
    }
</script>
@endsection