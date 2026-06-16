@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-8 mx-auto">

                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0">Add Banner</h4>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">
                                    Banner Name <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    name="banner_name"
                                    class="form-control"
                                    value="{{ old('banner_name') }}"
                                    required>

                                @error('banner_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                           <div class="mb-3">
                                <label>Banner Image</label>
                                <input type="file" name="banner" class="form-control"
                                    id="bannerInput" accept="image/*">

                                <div class="mt-3">
                                    <img id="bannerPreview"
                                        src=""
                                        style="display:none;max-width:250px;border:1px solid #ddd;padding:5px;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <button class="btn btn-success">
                                Save
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
    <script>
document.getElementById('bannerInput').addEventListener('change', function(e) {

    const file = e.target.files[0];

    if (file) {

        const reader = new FileReader();

        reader.onload = function(event) {
            const preview = document.getElementById('bannerPreview');

            preview.src = event.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }
});
</script>
@endsection
