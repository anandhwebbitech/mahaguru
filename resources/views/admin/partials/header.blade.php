<div class="header d-flex justify-content-between align-items-center">
    <style>
        .header h5 {
            font-weight: 600;
            color: #222;
        }

        /* User dropdown */
        .header .dropdown-toggle {
            color: #444;
            padding: 6px 12px;
            border-radius: 6px;
        }

        .header .dropdown-toggle:hover {
            background: #f5f5f5;
        }

        /* Dropdown */
        .dropdown-menu {
            border-radius: 10px;
            border: 1px solid #eee;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .dropdown-item:hover {
            background: #f3f6f9;
        }
    </style>
    <h5 class="mb-0">
        @yield('page-title', 'Dashboard')
    </h5>

    <div class="dropdown">

        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false">
            @auth
                @php
                    $user = auth()->user();
                @endphp

                {{-- <img src="{{ $user->profile_image ? asset('uploads/profile_images/' . $user->profile_image) : asset('default.png') }}"
                    alt="profile" width="40" height="40" class="rounded-circle me-2"
                    style="object-fit: cover; border:2px solid #0ea5e9;"> --}}

                <strong>{{ $user->name }}</strong>
            @endauth
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow">
            <li>
                {{-- <a class="dropdown-item" href="{{ route('admin.profile') }}">
                    <i class="fa fa-user me-2"></i> Profile
                </a> --}}
            </li>

            {{-- <li>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-cog me-2"></i> Settings
                </a>
            </li> --}}

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fa fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>

    </div>

</div>
