@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6 mx-auto">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Edit Size</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.sizes.update', $size->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- SIZE NAME --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Size Name <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ $size->name }}"
                                   class="form-control"
                                   placeholder="S, M, L, XL, XXL"
                                   required>

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- SIZE CODE --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Size Code
                            </label>

                            <input type="text"
                                   name="code"
                                   value="{{ $size->code }}"
                                   class="form-control"
                                   placeholder="38, 40, 42, 44">
                            
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- STATUS --}}
                        <div class="mb-3">
                            <label class="form-label">Status</label>

                            <select name="status" class="form-control">
                                <option value="1" {{ $size->status == 1 ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ $size->status == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="text-end">
                            <a href="{{ route('admin.sizes.index') }}"
                               class="btn btn-secondary">
                                Back
                            </a>

                            <button type="submit"
                                    class="btn btn-primary">
                                Update Size
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection