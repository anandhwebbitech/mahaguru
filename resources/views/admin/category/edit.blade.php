@extends('admin.layouts.app')
@section('content')

<form action="{{ route('admin.category.update',$category->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $category->name }}" class="form-control mb-3">
    <button class="btn btn-primary">Update</button>

</form>

@endsection