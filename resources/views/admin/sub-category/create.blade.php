@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-8 mx-auto">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Add Sub Category</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.subcategory.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Category <span class="text-danger">*</span>
                            </label>

                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>

                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Sub Category Name <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="sub_category_name"
                                   class="form-control"
                                   placeholder="Enter Sub Category Name"
                                   value="{{ old('sub_category_name') }}"
                                   required>

                            @error('sub_category_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>

                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.subcategory.index') }}"
                               class="btn btn-secondary">
                                Back
                            </a>

                            <button type="submit"
                                    class="btn btn-success">
                                Save Sub Category
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection