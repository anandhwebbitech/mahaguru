@extends('admin.layouts.app')

@section('content')
    @auth
        @if (auth()->user()->role == 1)
            <style>
                .dashboard-card {
                    border: none;
                    border-radius: 18px;
                    color: #fff;
                    padding: 25px;
                    transition: all .3s ease;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, .12);
                    overflow: hidden;
                    position: relative;
                }

                .dashboard-card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 18px 35px rgba(0, 0, 0, .18);
                }

                .dashboard-card::after {
                    content: '';
                    position: absolute;
                    right: -20px;
                    top: -20px;
                    width: 100px;
                    height: 100px;
                    background: rgba(255, 255, 255, .12);
                    border-radius: 50%;
                }

                .stat-title {
                    font-size: 15px;
                    opacity: .95;
                    margin-bottom: 8px;
                }

                .stat-value {
                    font-size: 34px;
                    font-weight: 700;
                    line-height: 1;
                }

                .card-icon {
                    font-size: 46px;
                    opacity: .25;
                }

                .gradient-blue {
                    background: linear-gradient(135deg, #4e73df, #224abe);
                }

                .gradient-green {
                    background: linear-gradient(135deg, #1cc88a, #169b6b);
                }

                .gradient-orange {
                    background: linear-gradient(135deg, #f6c23e, #dda20a);
                }

                .gradient-purple {
                    background: linear-gradient(135deg, #6f42c1, #4e2a84);
                }

                .gradient-red {
                    background: linear-gradient(135deg, #e74a3b, #c0392b);
                }

                .gradient-dark {
                    background: linear-gradient(135deg, #343a40, #000);
                }

                .gradient-cyan {
                    background: linear-gradient(135deg, #36b9cc, #258391);
                }

                .gradient-pink {
                    background: linear-gradient(135deg, #fd7e14, #e83e8c);
                }

                .gradient-maroon {
                    background: linear-gradient(135deg, #8b0000, #5a0000);
                }
            </style>

            <div class="container-fluid py-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0">Admin Dashboard</h2>
                    <span class="text-muted">Welcome Back, {{ auth()->user()->name }}</span>
                </div>

                <div class="row g-4">

                    <!-- Total Users -->
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card gradient-blue">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">Total Users</div>
                                    <div class="stat-value">{{ $userCount }}</div>
                                </div>
                                <i class="fa fa-users card-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card gradient-green">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">Total Orders</div>
                                    <div class="stat-value">{{ $orderCount }}</div>
                                </div>
                                <i class="fa fa-shopping-cart card-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Orders -->
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card gradient-orange">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">Pending Orders</div>
                                    <div class="stat-value">{{ $pendingOrders }}</div>
                                </div>
                                <i class="fa fa-clock card-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmed Orders -->
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card gradient-purple">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">Confirmed Orders</div>
                                    <div class="stat-value">{{ $confirmedOrders }}</div>
                                </div>
                                <i class="fa fa-check-circle card-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Delivered Orders -->
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card gradient-cyan">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">Delivered Orders</div>
                                    <div class="stat-value">{{ $deliveredOrders }}</div>
                                </div>
                                <i class="fa fa-truck card-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Returned Orders -->
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card gradient-red">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">Returned Orders</div>
                                    <div class="stat-value">{{ $returnedOrders }}</div>
                                </div>
                                <i class="fa fa-undo card-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Cancelled Orders -->
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card gradient-maroon">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">Cancelled Orders</div>
                                    <div class="stat-value">{{ $cancelledOrders }}</div>
                                </div>
                                <i class="fa fa-times-circle card-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Orders -->
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card gradient-pink">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">Today's Orders</div>
                                    <div class="stat-value">{{ $todayOrders }}</div>
                                </div>
                                <i class="fa fa-calendar card-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Products -->
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card gradient-dark">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">Total Products</div>
                                    <div class="stat-value">{{ $productCount }}</div>
                                </div>
                                <i class="fa fa-box card-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Coupons -->
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card gradient-blue">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">Active Coupons</div>
                                    <div class="stat-value">{{ $couponCount }}</div>
                                </div>
                                <i class="fa fa-ticket card-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Income -->
                    <div class="col-xl-3 col-md-6">
                        <div class="dashboard-card gradient-green">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-title">Total Income</div>
                                    <div class="stat-value">₹{{ number_format($totalIncome, 2) }}</div>
                                </div>
                                <i class="fa fa-inr card-icon"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    @endauth
@endsection
