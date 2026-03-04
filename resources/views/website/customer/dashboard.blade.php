@extends('website.layouts.app')
@section('title', 'Customer Dashboard')
@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">
@endpush
@section('page_id', 'customer_profile')
@section('website_content')
    <section class="user-profile section--padding">
        <div class="container-fluid">

            {{-- Scoped wrapper: ONLY dashboard area --}}
            <div class="bs-dashboard user-profile-section">

                {{-- Header --}}
                <div class="dashboard-heading">
                    <h5 class="dashboard-title m-0">Customer Dashboard</h5>

                    <div class="dashboard-switch d-flex align-items-center gap-3">
                        <span class="text d-none d-lg-inline">Switch Dashboard</span>

                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" role="switch" id="dashboardSwitch"
                                onclick="switchDashboard()">
                            <label class="form-check-label visually-hidden" for="dashboardSwitch">Switch Dashboard</label>
                        </div>
                    </div>
                </div>

                <div class="user-dashboard">
                    {{-- NAV --}}
                    <div class="nav nav-pills flex-lg-column user-dashboard-nav" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">

                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                            aria-selected="true">
                            <span class="text">Dashboard</span>
                        </button>

                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                            aria-selected="false">
                            <span class="text">Personal Info</span>
                        </button>

                        <button class="nav-link" id="v-pills-password-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-password" type="button" role="tab"
                            aria-controls="v-pills-password" aria-selected="false">
                            <span class="text">Change Password</span>
                        </button>

                        <button class="nav-link" id="v-pills-ticket-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-ticket" type="button" role="tab" aria-controls="v-pills-ticket"
                            aria-selected="false">
                            <span class="text">Support Ticket</span>
                        </button>

                        <a class="nav-link" href="{{ route('customer.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="text">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>

                    {{-- CONTENT --}}
                    <div class="tab-content nav-content flex-grow-1" id="v-pills-tabContent">

                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab" tabindex="0">

                            <p class="paragraph mb-1">Hello, Sajjad</p>
                            <h5 class="heading mb-3">Welcome to your Profile</h5>

                            <!-- 3 summary boxes -->
                            <div class="row g-4 mb-4">
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="bs-stat-card">
                                        <div class="bs-stat-icon">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </div>
                                        <div class="bs-stat-body">
                                            <p class="bs-stat-title mb-1">Total Orders</p>
                                            <h3 class="bs-stat-value mb-0">128</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="bs-stat-card bs-stat-card--success">
                                        <div class="bs-stat-icon">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                        <div class="bs-stat-body">
                                            <p class="bs-stat-title mb-1">Completed Orders</p>
                                            <h3 class="bs-stat-value mb-0">96</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-xl-4">
                                    <div class="bs-stat-card bs-stat-card--brand">
                                        <div class="bs-stat-icon">
                                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                        </div>
                                        <div class="bs-stat-body">
                                            <p class="bs-stat-title mb-1">Total Spent</p>
                                            <h3 class="bs-stat-value mb-0">৳ 58,450.00</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Orders table + pagination -->
                            <div class="bs-panel">
                                <div class="bs-panel-head d-flex align-items-center justify-content-between gap-3 mb-3">
                                    <h5 class="mb-0 bs-panel-title">My Orders</h5>

                                    <div class="d-flex align-items-center gap-2">
                                        <input type="text" class="form-control bs-search"
                                            placeholder="Search order...">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table bs-table align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width:70px;">#</th>
                                                <th>Order ID</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th class="text-end">Total</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td><span class="fw-semibold">#ORD-1001</span></td>
                                                <td>03 Mar, 2026</td>
                                                <td><span class="bs-badge bs-badge--success">Completed</span></td>
                                                <td class="text-end">৳ 2,450.00</td>
                                                <td class="text-end"><a href="#" class="bs-link-btn">View <i
                                                            class="fa-solid fa-arrow-right-long"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><span class="fw-semibold">#ORD-1002</span></td>
                                                <td>01 Mar, 2026</td>
                                                <td><span class="bs-badge bs-badge--info">Processing</span></td>
                                                <td class="text-end">৳ 1,299.00</td>
                                                <td class="text-end"><a href="#" class="bs-link-btn">View <i
                                                            class="fa-solid fa-arrow-right-long"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td><span class="fw-semibold">#ORD-1003</span></td>
                                                <td>28 Feb, 2026</td>
                                                <td><span class="bs-badge bs-badge--warning">Pending</span></td>
                                                <td class="text-end">৳ 5,650.00</td>
                                                <td class="text-end"><a href="#" class="bs-link-btn">View <i
                                                            class="fa-solid fa-arrow-right-long"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td><span class="fw-semibold">#ORD-1004</span></td>
                                                <td>25 Feb, 2026</td>
                                                <td><span class="bs-badge bs-badge--danger">Cancelled</span></td>
                                                <td class="text-end">৳ 799.00</td>
                                                <td class="text-end"><a href="#" class="bs-link-btn">View <i
                                                            class="fa-solid fa-arrow-right-long"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td><span class="fw-semibold">#ORD-1005</span></td>
                                                <td>22 Feb, 2026</td>
                                                <td><span class="bs-badge bs-badge--success">Completed</span></td>
                                                <td class="text-end">৳ 3,999.00</td>
                                                <td class="text-end"><a href="#" class="bs-link-btn">View <i
                                                            class="fa-solid fa-arrow-right-long"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td><span class="fw-semibold">#ORD-1006</span></td>
                                                <td>20 Feb, 2026</td>
                                                <td><span class="bs-badge bs-badge--info">Processing</span></td>
                                                <td class="text-end">৳ 1,050.00</td>
                                                <td class="text-end"><a href="#" class="bs-link-btn">View <i
                                                            class="fa-solid fa-arrow-right-long"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td><span class="fw-semibold">#ORD-1007</span></td>
                                                <td>18 Feb, 2026</td>
                                                <td><span class="bs-badge bs-badge--success">Completed</span></td>
                                                <td class="text-end">৳ 6,250.00</td>
                                                <td class="text-end"><a href="#" class="bs-link-btn">View <i
                                                            class="fa-solid fa-arrow-right-long"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td><span class="fw-semibold">#ORD-1008</span></td>
                                                <td>15 Feb, 2026</td>
                                                <td><span class="bs-badge bs-badge--warning">Pending</span></td>
                                                <td class="text-end">৳ 899.00</td>
                                                <td class="text-end"><a href="#" class="bs-link-btn">View <i
                                                            class="fa-solid fa-arrow-right-long"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>9</td>
                                                <td><span class="fw-semibold">#ORD-1009</span></td>
                                                <td>12 Feb, 2026</td>
                                                <td><span class="bs-badge bs-badge--success">Completed</span></td>
                                                <td class="text-end">৳ 4,120.00</td>
                                                <td class="text-end"><a href="#" class="bs-link-btn">View <i
                                                            class="fa-solid fa-arrow-right-long"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>10</td>
                                                <td><span class="fw-semibold">#ORD-1010</span></td>
                                                <td>10 Feb, 2026</td>
                                                <td><span class="bs-badge bs-badge--info">Processing</span></td>
                                                <td class="text-end">৳ 2,199.00</td>
                                                <td class="text-end"><a href="#" class="bs-link-btn">View <i
                                                            class="fa-solid fa-arrow-right-long"></i></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination (Bootstrap 5) -->
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
                                    <small class="text-muted">Showing 1–10 of 128</small>

                                    <nav aria-label="Orders pagination">
                                        <ul class="pagination mb-0">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1"
                                                    aria-disabled="true">Prev</a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                        </div>


                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab" tabindex="0">
                            <h5 class="heading mb-3">Personal Information</h5>

                            <div class="info-section">
                                <div class="w-100">
                                    <p class="mb-2"><strong>Name:</strong> {{ auth()->user()->name }}</p>
                                    <p class="mb-0"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-password" role="tabpanel"
                            aria-labelledby="v-pills-password-tab" tabindex="0">
                            <h5 class="heading mb-3">Change Password</h5>

                            {{-- Example form (Bootstrap-like inside scope) --}}
                            <form method="POST" action="#">
                                @csrf
                                <div class="bs-form-item">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" class="form-control" />
                                </div>

                                <div class="bs-form-item">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" />
                                </div>

                                <div class="bs-form-item">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" />
                                </div>

                                <div class="bs-form-actions">
                                    <button type="submit" class="shop-btn update-btn">Update</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="v-pills-ticket" role="tabpanel"
                            aria-labelledby="v-pills-ticket-tab" tabindex="0">
                            <h5 class="heading mb-3">Support Ticket</h5>
                            {{-- আপনার table/list এখানে --}}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
