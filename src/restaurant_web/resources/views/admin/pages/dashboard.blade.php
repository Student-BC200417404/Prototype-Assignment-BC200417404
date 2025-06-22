@extends('Admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Welcome To Eatz AI Dashboard</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="#" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Home</li>
    </ul>
</div>

<div class="row gy-4">
    <!-- KPI Cards -->
    <div class="col-xxl-2 col-md-4 col-sm-6 mb-4">
        <div class="card text-center p-3 bg-purple-light">
            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-lilac-200 border border-lilac-400 text-lilac-600">
                <i class="ri-price-tag-3-fill"></i>
            </span>
            <span class="text-neutral-700 d-block">Total Sales</span>
            <h6 class="mb-0 mt-4">$170,500.09</h6>
        </div>
    </div>
    <div class="col-xxl-2 col-md-4 col-sm-6 mb-4">
        <div class="card text-center p-3 bg-success-100">
            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-success-200 border border-success-400 text-success-600">
                <i class="ri-shopping-cart-2-fill"></i>
            </span>
            <span class="text-neutral-700 d-block">Total Orders</span>
            <h6 class="mb-0 mt-4">1,500</h6>
        </div>
    </div>
    <div class="col-xxl-2 col-md-4 col-sm-6 mb-4">
        <div class="card text-center p-3 bg-info-focus">
            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-info-200 border border-info-400 text-info-600">
                <i class="ri-group-3-fill"></i>
            </span>
            <span class="text-neutral-700 d-block">Total Customers</span>
            <h6 class="mb-0 mt-4">2,350</h6>
        </div>
    </div>
    <div class="col-xxl-2 col-md-4 col-sm-6 mb-4">
        <div class="card text-center p-3 bg-warning-100">
            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-warning-200 border border-warning-400 text-warning-600">
                <i class="ri-restaurant-2-fill"></i>
            </span>
            <span class="text-neutral-700 d-block">Menu Items</span>
            <h6 class="mb-0 mt-4">120</h6>
        </div>
    </div>
    <div class="col-xxl-2 col-md-4 col-sm-6 mb-4">
        <div class="card text-center p-3 bg-danger-100">
            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-danger-200 border border-danger-400 text-danger-600">
                <i class="ri-calendar-check-fill"></i>
            </span>
            <span class="text-neutral-700 d-block">Reservations</span>
            <h6 class="mb-0 mt-4">320</h6>
        </div>
    </div>
    <div class="col-xxl-2 col-md-4 col-sm-6 mb-4">
        <div class="card text-center p-3 bg-secondary-100">
            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-secondary-200 border border-secondary-400 text-secondary-600">
                <i class="ri-money-dollar-circle-line"></i>
            </span>
            <span class="text-neutral-700 d-block">Total Revenue</span>
            <h6 class="mb-0 mt-4">$98,200.00</h6>
        </div>
    </div>
</div>

<div class="row gy-4 mt-2">
    <!-- Sales/Orders Chart -->
    <div class="col-xxl-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Sales & Orders Trend</h5>
            </div>
            <div class="card-body">
                <div id="sales-orders-chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    <!-- Top Menu Items -->
    <div class="col-xxl-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Top Menu Items</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Spicy Chicken Burger <span class="badge bg-primary rounded-pill">320 sold</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Veggie Delight Pizza <span class="badge bg-success rounded-pill">280 sold</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Classic Caesar Salad <span class="badge bg-info rounded-pill">210 sold</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        BBQ Ribs <span class="badge bg-warning rounded-pill">180 sold</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Chocolate Lava Cake <span class="badge bg-danger rounded-pill">150 sold</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row gy-4 mt-2">
    <!-- Recent Orders Table -->
    <div class="col-xxl-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Orders</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1001</td>
                            <td>John Doe</td>
                            <td>2024-06-01</td>
                            <td><span class="badge bg-success">Completed</span></td>
                            <td>$120.00</td>
                        </tr>
                        <tr>
                            <td>#1002</td>
                            <td>Jane Smith</td>
                            <td>2024-06-01</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>$85.50</td>
                        </tr>
                        <tr>
                            <td>#1003</td>
                            <td>Mike Johnson</td>
                            <td>2024-05-31</td>
                            <td><span class="badge bg-danger">Cancelled</span></td>
                            <td>$45.00</td>
                        </tr>
                        <tr>
                            <td>#1004</td>
                            <td>Emily Brown</td>
                            <td>2024-05-31</td>
                            <td><span class="badge bg-success">Completed</span></td>
                            <td>$210.00</td>
                        </tr>
                        <tr>
                            <td>#1005</td>
                            <td>Chris Lee</td>
                            <td>2024-05-30</td>
                            <td><span class="badge bg-success">Completed</span></td>
                            <td>$60.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Recent Reservations Table -->
    <div class="col-xxl-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Reservations</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#R-2001</td>
                            <td>Sarah Parker</td>
                            <td>2024-06-01</td>
                            <td>7:00 PM</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                        </tr>
                        <tr>
                            <td>#R-2002</td>
                            <td>David Kim</td>
                            <td>2024-06-01</td>
                            <td>8:30 PM</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>#R-2003</td>
                            <td>Linda White</td>
                            <td>2024-05-31</td>
                            <td>6:00 PM</td>
                            <td><span class="badge bg-danger">Cancelled</span></td>
                        </tr>
                        <tr>
                            <td>#R-2004</td>
                            <td>James Green</td>
                            <td>2024-05-31</td>
                            <td>9:00 PM</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                        </tr>
                        <tr>
                            <td>#R-2005</td>
                            <td>Olivia Black</td>
                            <td>2024-05-30</td>
                            <td>7:30 PM</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row gy-4 mt-2">
    <!-- Recent Error Logs Table -->
    <div class="col-xxl-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Error Logs</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Message</th>
                            <th>Level</th>
                            <th>User</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Database connection failed</td>
                            <td><span class="badge bg-danger">Error</span></td>
                            <td>Admin</td>
                            <td>2024-06-01 10:15</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Payment gateway timeout</td>
                            <td><span class="badge bg-warning">Warning</span></td>
                            <td>System</td>
                            <td>2024-06-01 09:50</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Invalid reservation data</td>
                            <td><span class="badge bg-danger">Error</span></td>
                            <td>Admin</td>
                            <td>2024-05-31 18:22</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var options = {
        chart: {
            type: 'line',
            height: 300
        },
        series: [{
            name: 'Sales',
            data: [1200, 1500, 1800, 1700, 2100, 2500, 2300, 2200, 2000, 2100, 2400, 2600]
        }, {
            name: 'Orders',
            data: [100, 120, 140, 130, 160, 180, 170, 165, 150, 155, 175, 190]
        }],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        }
    };
    var chart = new ApexCharts(document.querySelector("#sales-orders-chart"), options);
    chart.render();
});
</script>
