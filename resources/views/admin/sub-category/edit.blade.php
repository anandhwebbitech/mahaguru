@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-8 mx-auto">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Edit Sub Category</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.subcategory.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">
                                Category <span class="text-danger">*</span>
                            </label>

                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>

                                @foreach($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $category->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Sub Category Name <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="sub_category_name"
                                   value="{{ $category->sub_category_name }}"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>

                            <select name="status" class="form-control">
                                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.subcategory.index') }}"
                               class="btn btn-secondary">
                                Back
                            </a>

                            <button type="submit"
                                    class="btn btn-primary">
                                Update Sub Category
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection