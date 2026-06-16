@extends('admin.layouts.app')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Sub-Category List</h2>
    <a href="{{ route('admin.subcategory.create') }}" class="btn btn-primary">
        Add Sub-Category
    </a>
</div>

<table class="table table-bordered table-hover align-middle" id="couponTable">
    <thead class="table-dark">
        <tr>
            <th>S.No</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($categories as $cat)
        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>
                {{ $cat->category->name ?? '-' }}
            </td>

            <td>
                {{ $cat->sub_category_name }}
            </td>

            <td class="d-flex gap-2">

                <a href="{{ route('admin.subcategory.edit', $cat->id) }}"
                    class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('admin.subcategory.destroy', $cat->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger btn-sm">
                        Delete
                    </button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection