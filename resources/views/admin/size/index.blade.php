@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h4>Size List</h4>

            <a href="{{ route('admin.sizes.create') }}"
               class="btn btn-primary">
                Add Size
            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Size Name</th>
                        <th>Code</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($sizes as $key => $size)

                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $size->name }}</td>
                        <td>{{ $size->code }}</td>

                        <td>
                            @if($size->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td>

                            <a href="{{ route('admin.sizes.edit',$size->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.sizes.destroy',$size->id) }}"
                                  method="POST"
                                  style="display:inline-block">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('Delete?')"
                                        class="btn btn-danger btn-sm">
                                    Delete
                                </button>

                            </form>

                        </td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection