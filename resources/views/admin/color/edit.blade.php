@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6 mx-auto">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Edit Color</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.colors.update', $color->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- COLOR NAME --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Color Name <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ $color->name }}"
                                   class="form-control"
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

                            <div class="d-flex align-items-center gap-2">

                                <input type="color"
                                       name="code"
                                       value="{{ $color->code }}"
                                       class="form-control form-control-color">

                                {{-- preview box --}}
                                <div style="
                                    width: 35px;
                                    height: 35px;
                                    background: {{ $color->code }};
                                    border: 1px solid #ccc;
                                    border-radius: 4px;">
                                </div>

                            </div>
                        </div>

                        {{-- STATUS --}}
                        <div class="mb-3">
                            <label class="form-label">Status</label>

                            <select name="status" class="form-control">
                                <option value="1" {{ $color->status == 1 ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ $color->status == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="text-end">
                            <a href="{{ route('admin.colors.index') }}"
                               class="btn btn-secondary">
                                Back
                            </a>

                            <button type="submit"
                                    class="btn btn-primary">
                                Update Color
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection