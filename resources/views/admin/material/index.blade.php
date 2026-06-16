@extends('admin.layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Material List</h2>
        <a href="{{ route('admin.material.create') }}" class="btn btn-primary">Add Material</a>
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
            @foreach ($materials as $mat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mat->name }}</td>
                    <td class="d-flex gap-2">

                        <a href="{{ route('admin.material.edit', $mat->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.material.destroy', $mat->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this material?');">

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
    <script>
        function deleteMaterial(id) {
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: '/admin/material/delete/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        location.reload();
                    }
                });
            }
        }
    </script>
@endsection
