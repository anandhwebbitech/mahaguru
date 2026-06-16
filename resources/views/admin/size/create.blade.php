@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6 mx-auto">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4>Add Size</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.sizes.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Size Name *</label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="S, M, L, XL"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Size Code</label>

                            <input type="text"
                                   name="code"
                                   class="form-control"
                                   placeholder="40,42,44 etc">
                        </div>

                        <div class="mb-3">
                            <label>Status</label>

                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.sizes.index') }}"
                               class="btn btn-secondary">
                                Back
                            </a>

                            <button type="submit"
                                    class="btn btn-success">
                                Save Size
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection