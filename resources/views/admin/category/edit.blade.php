@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i> Edit Category</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Category Name Input --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium text-secondary">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Category Image Input --}}
                        <div class="mb-4">
                            <label for="image" class="form-label fw-medium text-secondary">Category Image (Leave blank if not changing)</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this);">
                            <small class="text-muted d-block mt-1">Max upload size: 2MB</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Current & Live Preview --}}
                            <div class="mt-3 d-flex gap-3 align-items-center">
                                @if($category->image && file_exists(public_path('uploads/categories/' . $category->image)))
                                    <div>
                                        <small class="text-muted d-block mb-1">Current Image:</small>
                                        <img src="{{ asset('uploads/categories/' . $category->image) }}" class="img-thumbnail rounded" style="max-height: 100px;">
                                    </div>
                                @endif
                                
                                <div id="previewContainer" class="d-none">
                                    <small class="text-success d-block mb-1">New Preview:</small>
                                    <img id="imagePreview" src="#" alt="New Preview" class="img-thumbnail rounded border-success" style="max-height: 100px;">
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2 justify-content-end border-top pt-3">
                            <a href="{{ route('admin.category.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-warning px-4 text-white">Update Category</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const container = document.getElementById('previewContainer');
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "#";
            container.classList.add('d-none');
        }
    }
</script>
@endsection