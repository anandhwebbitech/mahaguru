@extends('admin.layouts.app')
@section('content')

<form action="{{ route('admin.material.update',$material->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $material->name }}" class="form-control mb-3">
    <button class="btn btn-primary">Update</button>

</form>

@endsection