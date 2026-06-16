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
    <h2>Color List</h2>

    <a href="{{ route('admin.colors.create') }}" class="btn btn-primary">
        Add Color
    </a>
</div>

<table class="table table-bordered table-hover align-middle">

    <thead class="table-dark">
        <tr>
            <th>S.No</th>
            <th>Color</th>
            <th>Preview</th>
            <th>Code</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($colors as $color)
        <tr>

            <td>{{ $loop->iteration }}</td>

            {{-- COLOR NAME --}}
            <td>
                {{ $color->name }}
            </td>

            {{-- COLOR BOX --}}
            <td>
                <div style="
                    width: 30px;
                    height: 30px;
                    background: {{ $color->code }};
                    border: 1px solid #ccc;
                    border-radius: 4px;">
                </div>
            </td>

            {{-- COLOR CODE --}}
            <td>
                {{ $color->code }}
            </td>

            {{-- STATUS --}}
            <td>
                @if($color->status == 1)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </td>

            {{-- ACTION --}}
            <td class="d-flex gap-2">

                <a href="{{ route('admin.colors.edit', $color->id) }}"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('admin.colors.destroy', $color->id) }}"
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