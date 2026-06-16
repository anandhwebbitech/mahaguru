@extends('admin.layouts.app')

@section('page-title','Settings')

@section('content')

<div class="card p-4 shadow-sm">

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.profile') }}">User Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active">Settings</a>
        </li>
    </ul>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Site Name</label>
                <input type="text" name="site_name" class="form-control"
                       value="{{ $setting->site_name ?? '' }}">
            </div>

            <div class="col-md-6">
                <label>Admin Email</label>
                <input type="email" name="admin_email" class="form-control"
                       value="{{ $setting->admin_email ?? '' }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control">
            </div>

            <div class="col-md-6">
                <label>Favicon</label>
                <input type="file" name="favicon" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Footer Text</label>
            <textarea name="footer_text" class="form-control" rows="3">
                {{ $setting->footer_text ?? '' }}
            </textarea>
        </div>

        <button class="btn btn-success">Save Settings</button>
    </form>

</div>

@endsection
