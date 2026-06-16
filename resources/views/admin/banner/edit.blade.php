@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-8 mx-auto">

                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Banner</h4>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- <div class="mb-3">
                                <img src="{{ asset('uploads/banner/' . $banner->banner) }}" width="150">
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    Banner Name <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    name="banner_name"
                                    value="{{ old('banner_name', $banner->banner_name) }}"
                                    class="form-control"
                                    required>

                                @error('banner_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Current Banner</label><br>

                                <img id="bannerPreview"
                                    src="{{ asset('public/uploads/banner/' . $banner->banner) }}"
                                    style="max-width:250px;border:1px solid #ddd;padding:5px;">
                            </div>

                            <div class="mb-3">
                                <label>Change Banner Image</label>
                                <input type="file"
                                    name="banner"
                                    class="form-control"
                                    id="bannerInput"
                                    accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ $banner->status == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ $banner->status == 0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <button class="btn btn-primary">
                                Update
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
