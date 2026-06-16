@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h2 class="mb-4 text-center">Select Payment Method</h2>

    <div class="row justify-content-center">

        <div class="col-md-4">
            <div class="card p-3 text-center selectable" data-method="online">
                <img src="{{ asset('public/assets/images/razorpay.png') }}" class="img-fluid" style="height:140px">
                <h5 class="mt-2">Online Payment</h5>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center selectable" data-method="cod">
                <img src="{{ asset('public/assets/images/cod.svg') }}" class="img-fluid" style="height:140px">
                <h5 class="mt-2">Cash on Delivery</h5>
            </div>
        </div>ront

    </div>

    <div class="text-center mt-4">
        <button id="confirmPayment" class="btn btn-primary px-5 py-2" disabled>
            Confirm
        </button>
    </div>

</div>
@push('scripts')

<script>
let paymentMethod = null;

$(".selectable").click(function() {

    $(".selectable").removeClass("border border-primary");
    $(this).addClass("border border-primary");

    paymentMethod = $(this).data("method");

    $("#confirmPayment").prop("disabled", false);
});

$("#confirmPayment").click(function() {

    if (!paymentMethod) return;

    let orderId = "{{ $order->id }}";

   if (paymentMethod === 'cod') {
        window.location.href = "{{ url('payment/cod') }}/" + orderId;
    } else {
        window.location.href = "{{ url('payment/razorpay') }}/" + orderId;
    }
});
</script>
@endpush

@endsection
