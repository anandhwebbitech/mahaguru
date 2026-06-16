@extends('admin.layouts.app')

@section('page-title', 'Profile')

@section('content')

    <div class="card p-4 shadow-sm">

        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active">User Profile</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.settings') }}">Settings</a>
            </li> --}}
        </ul>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">

            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                </div>

                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Profile Image</label>
                    <input type="file" name="profile_image" class="form-control" onchange="previewImage(event)">
                    <img id="preview" width="80" class="mt-2">
                </div>

                <div class="col-md-6">
                    <label>New Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control">
                        <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                            <i id="toggleIcon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <img src="{{ $user->profile_image ? asset('uploads/profile_images/' . $user->profile_image) . '?' . time() : asset('default.png') }}"
                    width="80">
            </div>

            <button class="btn btn-primary">Update Profile</button>
        </form>

    </div>
    <script>
        function previewImage(event) {
            let reader = new FileReader();
            reader.onload = function() {
                document.getElementById('preview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script>
        function togglePassword() {
            let passwordField = document.getElementById("password");
            let icon = document.getElementById("toggleIcon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
