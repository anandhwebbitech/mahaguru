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
    <a href="{{ route('admin.banner.create') }}" class="btn btn-primary">
        Add Banner
    </a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Banner Name</th>
            <th>Banner</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($banners as $banner)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $banner->banner_name }}</td>
            <td>
                <img src="{{ asset('public/uploads/banner/'.$banner->banner) }}"
                     width="120">
            </td>

            <td>
                {{ $banner->status == 1 ? 'Active' : 'Inactive' }}
            </td>

            <td>
                <a href="{{ route('admin.banner.edit',$banner->id) }}"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('admin.banner.destroy',$banner->id) }}"
                      method="POST"
                      style="display:inline-block;">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection