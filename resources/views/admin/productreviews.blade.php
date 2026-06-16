@extends('admin.layouts.app')

@section('content')
<section class="content-inner">
    <div class="container">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Product Reviews</h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>S.No</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <!-- <th>Status</th> -->
                                <th>Review Date</th>
                            </tr>
                        </thead>

                        <tbody>
                        @php
                            $statusMap = [
                                1 => ['Pending', 'warning'],
                                2 => ['Approved', 'success'],
                                3 => ['Rejected', 'danger'],
                            ];
                        @endphp

                        @foreach($reviews as $review)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $review->user->name ?? 'N/A' }}</td>

                            <!-- <td>{{ $review->product->product_name ?? 'N/A' }}</td> -->
                            <td>
                                @if($review->product)
                                    <a href="{{ url('product/'.$review->product->id) }}" class="text-decoration-none">
                                        {{ $review->product->product_name }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>

                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-{{ $i <= $review->rating ? 'warning' : 'secondary' }}">
                                        ★
                                    </span>
                                @endfor
                            </td>

                            <td>{{ $review->review }}</td>

                            <!-- <td>
                                <span class="badge bg-{{ $statusMap[$review->status][1] }}">
                                    {{ $statusMap[$review->status][0] }}
                                </span>
                            </td> -->

                            <td>{{ $review->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>

                    <div class="d-flex justify-content-end">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
{{-- @push('scripts') --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).on('change', '.review-status', function () {

    let select = $(this);
    let id = select.data('id');
    let status = select.val();

    select.prop('disabled', true);

    $.ajax({
        url: "{{ url('reviews/update-status') }}/" + id,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            status: status
        },
        success: function (res) {
            Swal.fire({
                icon: 'success',
                title: 'Updated',
                text: res.message,
                timer: 1200,
                showConfirmButton: false
            });
        },
        error: function () {
            Swal.fire('Error', 'Update failed', 'error');
        },
        complete: function () {
            select.prop('disabled', false);
        }
    });
});
</script>
{{-- @endpush --}}