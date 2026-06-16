@extends('admin.layouts.app')

@section('title', 'User List')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<section class="content-inner">
    <div class="container">

        <h2 class="text-center mb-4">User List</h2>

        <!-- Status Filter -->
        <form method="GET" action="{{ route('admin.userlist') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="status" class="form-control select2" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status')=='1' ? 'selected' : '' }}>Active</option>
                        <option value="2" {{ request('status')=='2' ? 'selected' : '' }}>In-Active</option>
                       
                    </select>
                </div>
            </div>
        </form>

        <!-- Orders Table -->
        <div class="card p-3">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No #</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    $statusText = [
                    1 => 'Active',
                    2 => 'In-Active',
                    ];
                    $statusBadge = [
                        1 => 'success',   // Confirmed → green
                        2 => 'danger',    // Cancelled → red
                    ];

                    @endphp
                    @forelse ($users as $key=>$user)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $user->name ?? 'N/A' }}</td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->phone  }}</td>
                        <td>
                            <span class="badge bg-{{ $statusBadge[$user->status] ?? 'secondary' }}">
                                {{ $statusText[$user->status] ?? 'Unknown' }}
                            </span>

                        </td>
                       
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No Users Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

         
        </div>

    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
      $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Status",
            allowClear: true,
            width: '100%'
        });
    });
    
</script>
@endsection