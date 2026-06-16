@extends('admin.layouts.app')
@section('content')

<form action="{{ route('admin.category.store') }}" method="POST">
    @csrf
    <input type="text" name="name" class="form-control mb-3" placeholder="Category Name">
    <button class="btn btn-success">Save</button>
</form>

@endsection