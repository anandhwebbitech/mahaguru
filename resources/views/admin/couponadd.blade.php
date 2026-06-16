@extends('admin.layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <section class="content-inner">
        <div class="container">
            <!-- Add Coupon Form -->
            <div class="col-md-12 col-12">
                <div class="card mb-5">
                    <div class="card-header text-dark header-bg">
                        <h4>Add Coupon Code</h4>
                    </div>

                    <div class="card-body">
                        <form id="addCouponForm" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <!-- Coupon Form Inputs -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Coupon Code</label>
                                    <input type="text" class="form-control" name="code" placeholder="SAVE20" required>
                                    <input type="hidden" name="coupon_id" id="coupon_id">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Discount Type</label>
                                    <select class="form-control" name="discount_type" id="discount_type" required>
                                        <option value="">Select Type</option>
                                        <option value="1">Percentage (%)</option>
                                        <option value="2">Fixed Amount (₹)</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Discount Value</label>
                                    <input type="number" class="form-control" name="discount" id="discount" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Minimum Order Amount</label>
                                    <input type="number" class="form-control" name="min_order_amount" placeholder="500">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Maximum Discount</label>
                                    <input type="number" class="form-control" name="max_discount" placeholder="200">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Usage Limit</label>
                                    <input type="number" class="form-control" name="usage_limit" placeholder="10">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="date" class="form-control" name="expiry_date" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-4 d-flex align-items-end mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Add Coupon</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Coupon List Table -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header header-bg text-dark">
                        <h4>Coupon List</h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-hover align-middle" id="couponTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>S.No</th>
                                    <th>Coupon Code</th>
                                    <th>Discount Type</th>
                                    <th>Discount Value</th>
                                    <th>Min Order Amount</th>
                                    <th>Max Discount</th>
                                    <th>Usage Limit</th>
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $index => $coupon)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $coupon->coupon_code }}</td>
                                        <td> {{ $coupon->discount_type == 1 ? 'Percentage' : 'Fixed' }}</td>
                                        <td>{{ $coupon->discount }}</td>
                                        <td>{{ $coupon->min_order_amount ?? '-' }}</td>
                                        <td>{{ $coupon->max_discount ?? '-' }}</td>
                                        <td>{{ $coupon->usage_limit ?? '-' }}</td>
                                        <td>{{ $coupon->expiry_date }} </td>
                                        <td>
                                            @if ($coupon->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Actions like Edit/Delete -->
                                            <button class="btn btn-sm btn-warning editCouponBtn"
                                                data-id="{{ $coupon->id }}" data-code="{{ $coupon->coupon_code }}"
                                                data-discount_type="{{ $coupon->discount_type }}"
                                                data-discount="{{ $coupon->discount }}"
                                                data-min_order="{{ $coupon->min_order_amount }}"
                                                data-max_discount="{{ $coupon->max_discount }}"
                                                data-usage_limit="{{ $coupon->usage_limit }}"
                                                data-expiry="{{ $coupon->expiry_date }}"
                                                data-status="{{ $coupon->status }}">
                                                Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger deleteCouponBtn"
                                                data-id="{{ $coupon->id }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($coupons->isEmpty())
                            <p class="text-center mt-3">No coupons found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- @push('scripts') --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#addCouponForm').on('submit', function(e) {
            e.preventDefault();

            let id = $('#coupon_id').val();
            let url = id ?
                "{{ url('admin/coupon/update') }}/" + id :
                "{{ route('admin.coupon.store') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong'
                    });
                }
            });
        });
        $(document).on('click', '.editCouponBtn', function() {
            $('#coupon_id').val($(this).data('id'));
            $('input[name="code"]').val($(this).data('code'));
            $('select[name="discount_type"]').val($(this).data('discount_type'));
            $('input[name="discount"]').val($(this).data('discount'));
            $('input[name="min_order_amount"]').val($(this).data('min_order'));
            $('input[name="max_discount"]').val($(this).data('max_discount'));
            $('input[name="usage_limit"]').val($(this).data('usage_limit'));
            $('input[name="expiry_date"]').val($(this).data('expiry'));
            $('select[name="status"]').val($(this).data('status'));

            // Change button text
            $('#addCouponForm button[type="submit"]').text('Update Coupon');

            // Scroll to form
            $('html, body').animate({
                scrollTop: $('#addCouponForm').offset().top - 100
            }, 500);
        });
        $(document).on('click', '.deleteCouponBtn', function() {

            let couponId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This coupon will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ url('coupon/delete') }}/" + couponId,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    });

                }
            });
        });
    </script>
    {{-- @endpush --}}
@endsection
