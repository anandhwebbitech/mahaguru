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
    <h2>Category List</h2>
    <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
        Add Category
    </a>
</div>

<table class="table table-bordered table-hover align-middle" id="couponTable">
    <thead class="table-dark">
        <tr>
            <th>S.No</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($categories as $cat)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cat->name }}</td>
                <td class="d-flex gap-2">

                    <a href="{{ route('admin.category.edit', $cat->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    {{-- DELETE OPTION --}}
                    <form action="{{ route('admin.category.destroy', $cat->id) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this category?');">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection