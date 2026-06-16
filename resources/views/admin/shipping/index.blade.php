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
    <h2>Shipping Charge List</h2>

    <!-- ஷிப்பிங் கிரியேட் பக்கத்திற்கான ரூட் -->
    <a href="{{ route('admin.shipping.create') }}" class="btn btn-primary">
        Add Shipping Charge
    </a>
</div>

<table class="table table-bordered table-hover align-middle">

    <thead class="table-dark">
        <tr>
            <th>S.No</th>
            <th>Country</th>
            <th>State</th>
            <th>Charge Amount (₹)</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($shippings as $shipping)
        <tr>

            <td>{{ $loop->iteration }}</td>

            {{-- COUNTRY NAME --}}
            <td>
                {{ $shipping->country }}
            </td>

            {{-- STATE NAME --}}
            <td>
                @if($shipping->state == 'Other States')
                    <span class="badge bg-secondary">Other States (Default)</span>
                @else
                    {{ $shipping->state }}
                @endif
            </td>

            {{-- CHARGE AMOUNT --}}
            <td>
                <strong>₹{{ number_format($shipping->charge_amount, 2) }}</strong>
            </td>

            {{-- ACTION BUTTONS --}}
            <td class="d-flex gap-2">

                <!-- எடிட் செய்வதற்கான ரூட் -->
                <a href="{{ route('admin.shipping.edit', $shipping->id) }}"
                class="btn btn-warning btn-sm">
                    Edit
                </a>

                <!-- டெலிட் செய்வதற்கான ரூட் -->
                <form action="{{ route('admin.shipping.destroy', $shipping->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this shipping charge?')">

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
        
        @if($shippings->isEmpty())
        <tr>
            <td colspan="5" class="text-center text-muted">No shipping charges added yet.</td>
        </tr>
        @endif
    </tbody>

</table>

@endsection