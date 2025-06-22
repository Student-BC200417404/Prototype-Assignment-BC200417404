@extends('admin.layout.app')

@section('title', 'Reports')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Reports</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Reports</li>
        </ul>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">All Reports</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><a href="#">Sales Report</a> (placeholder)</li>
                <li class="list-group-item"><a href="#">Order Report</a> (placeholder)</li>
                <li class="list-group-item"><a href="#">Customer Report</a> (placeholder)</li>
                <li class="list-group-item"><a href="#">Menu Performance Report</a> (placeholder)</li>
                <li class="list-group-item"><a href="#">Reservation Report</a> (placeholder)</li>
                <li class="list-group-item"><a href="#">Table Utilization Report</a> (placeholder)</li>
                <li class="list-group-item"><a href="#">Category Report</a> (placeholder)</li>
            </ul>
            <p class="mt-4 text-muted">Select a report above to view details. (You can implement each report as a separate page or modal.)</p>
        </div>
    </div>
</div>
@endsection 