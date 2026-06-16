@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6 mx-auto">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Add Color</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.colors.store') }}" method="POST">
                        @csrf

                        {{-- COLOR NAME --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Color Name <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Enter Color Name (e.g. Red)"
                                   value="{{ old('name') }}"
                                   required>

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- COLOR CODE --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Color Code
                            </label>

                            <input type="color"
                                   name="code"
                                   class="form-control form-control-color"
                                   value="#000000">

                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- STATUS --}}
                        <div class="mb-3">
                            <label class="form-label">Status</label>

                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="text-end">
                            <a href="{{ route('admin.colors.index') }}"
                               class="btn btn-secondary">
                                Back
                            </a>

                            <button type="submit"
                                    class="btn btn-success">
                                Save Color
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection