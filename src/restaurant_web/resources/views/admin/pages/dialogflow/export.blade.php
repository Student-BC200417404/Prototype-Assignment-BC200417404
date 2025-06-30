@extends('admin.layout.app')
@section('title', 'Dialogflow Entity Exports')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="avatar-sm rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center">
                                <i class="ri-chat-round-dots-line text-primary font-size-24"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-1">Dialogflow Entity Exports</h4>
                            <p class="text-muted mb-0">Export restaurant data for Google Dialogflow integration</p>
                        </div>
                    </div>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active">Dialogflow Exports</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="row text-center g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-primary text-white"><i class="ri-restaurant-line"></i></div>
                    <div class="stat-value">{{ $stats['categories'] }}</div>
                    <div class="stat-label">Menu Categories</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-success text-white"><i class="ri-menu-line"></i></div>
                    <div class="stat-value">{{ $stats['menu_items'] }}</div>
                    <div class="stat-label">Menu Items</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-warning text-white"><i class="ri-question-line"></i></div>
                    <div class="stat-value">{{ $stats['faq_topics'] }}</div>
                    <div class="stat-label">FAQ Topics</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-info text-white"><i class="ri-user-line"></i></div>
                    <div class="stat-value">{{ $stats['customer_names'] }}</div>
                    <div class="stat-label">Customer Names</div>
                </div>
            </div>
        </div>

        <!-- Export Cards -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="card-title mb-1">Entity Exports</h4>
                                <p class="text-muted mb-0">Download CSV files in Google Dialogflow format</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm" onclick="downloadAll()">
                                    <i class="ri-download-line me-1"></i> Download All
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" onclick="showInstructions()">
                                    <i class="ri-information-line me-1"></i> Instructions
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Menu Categories -->
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card border-0 shadow-sm h-100 export-card" data-entity="menu-categories">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-sm rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="ri-restaurant-line text-primary font-size-20"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Menu Categories</h6>
                                                <p class="text-muted small mb-0">Restaurant menu categories</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-primary-subtle text-primary">{{ $stats['categories'] }} items</span>
                                            <a href="{{ route('admin.dialogflow.export.menu-categories') }}" class="btn btn-primary btn-sm">
                                                <i class="ri-download-line me-1"></i> Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card border-0 shadow-sm h-100 export-card" data-entity="menu-items">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-sm rounded-circle bg-success-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="ri-menu-line text-success font-size-20"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Menu Items</h6>
                                                <p class="text-muted small mb-0">Individual food and drink items</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-success-subtle text-success">{{ $stats['menu_items'] }} items</span>
                                            <a href="{{ route('admin.dialogflow.export.menu-items') }}" class="btn btn-success btn-sm">
                                                <i class="ri-download-line me-1"></i> Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ Topics -->
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card border-0 shadow-sm h-100 export-card" data-entity="faq-topics">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-sm rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="ri-question-line text-warning font-size-20"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">FAQ Topics</h6>
                                                <p class="text-muted small mb-0">Frequently asked question categories</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-warning-subtle text-warning">{{ $stats['faq_topics'] }} items</span>
                                            <a href="{{ route('admin.dialogflow.export.faq-topics') }}" class="btn btn-warning btn-sm">
                                                <i class="ri-download-line me-1"></i> Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quantities -->
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card border-0 shadow-sm h-100 export-card" data-entity="quantities">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-sm rounded-circle bg-info-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="ri-number-1 text-info font-size-20"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Quantities</h6>
                                                <p class="text-muted small mb-0">Number and quantity expressions</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-info-subtle text-info">12 items</span>
                                            <a href="{{ route('admin.dialogflow.export.quantities') }}" class="btn btn-info btn-sm">
                                                <i class="ri-download-line me-1"></i> Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Types -->
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card border-0 shadow-sm h-100 export-card" data-entity="status-types">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-sm rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="ri-check-line text-secondary font-size-20"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Status Types</h6>
                                                <p class="text-muted small mb-0">Order and reservation statuses</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-secondary-subtle text-secondary">8 items</span>
                                            <a href="{{ route('admin.dialogflow.export.status-types') }}" class="btn btn-secondary btn-sm">
                                                <i class="ri-download-line me-1"></i> Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Date/Time -->
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card border-0 shadow-sm h-100 export-card" data-entity="datetime">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-sm rounded-circle bg-dark-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="ri-time-line text-dark font-size-20"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Date/Time</h6>
                                                <p class="text-muted small mb-0">Time and date expressions</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-dark-subtle text-dark">16 items</span>
                                            <a href="{{ route('admin.dialogflow.export.datetime') }}" class="btn btn-dark btn-sm">
                                                <i class="ri-download-line me-1"></i> Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Party Size -->
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card border-0 shadow-sm h-100 export-card" data-entity="party-size">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-sm rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="ri-group-line text-danger font-size-20"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Party Size</h6>
                                                <p class="text-muted small mb-0">Group size and party numbers</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-danger-subtle text-danger">12 items</span>
                                            <a href="{{ route('admin.dialogflow.export.party-size') }}" class="btn btn-danger btn-sm">
                                                <i class="ri-download-line me-1"></i> Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Names -->
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card border-0 shadow-sm h-100 export-card" data-entity="names">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-sm rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="ri-user-line text-primary font-size-20"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Names</h6>
                                                <p class="text-muted small mb-0">Customer and user names</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-primary-subtle text-primary">{{ $stats['customer_names'] }} items</span>
                                            <a href="{{ route('admin.dialogflow.export.names') }}" class="btn btn-primary btn-sm">
                                                <i class="ri-download-line me-1"></i> Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Emails -->
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card border-0 shadow-sm h-100 export-card" data-entity="emails">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-sm rounded-circle bg-success-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="ri-mail-line text-success font-size-20"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Emails</h6>
                                                <p class="text-muted small mb-0">Email addresses and patterns</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-success-subtle text-success">{{ $stats['emails'] }} items</span>
                                            <a href="{{ route('admin.dialogflow.export.emails') }}" class="btn btn-success btn-sm">
                                                <i class="ri-download-line me-1"></i> Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Phones -->
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card border-0 shadow-sm h-100 export-card" data-entity="phones">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-sm rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="ri-phone-line text-warning font-size-20"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Phones</h6>
                                                <p class="text-muted small mb-0">Phone numbers and patterns</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-warning-subtle text-warning">{{ $stats['phones'] }} items</span>
                                            <a href="{{ route('admin.dialogflow.export.phones') }}" class="btn btn-warning btn-sm">
                                                <i class="ri-download-line me-1"></i> Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructions Modal -->
        <div class="modal fade" id="instructionsModal" tabindex="-1" aria-labelledby="instructionsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="instructionsModalLabel">
                            <i class="ri-information-line text-primary me-2"></i>
                            CSV Format Instructions
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">CSV Format Requirements:</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="ri-check-line text-success me-2"></i>
                                        Each entry corresponds to a new line
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line text-success me-2"></i>
                                        Reference value and synonyms separated by commas
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line text-success me-2"></i>
                                        Each value enclosed in double-quotes
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line text-success me-2"></i>
                                        Reference value at the beginning of the line
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line text-success me-2"></i>
                                        Reference value included twice for matching
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Example Format:</h6>
                                <div class="bg-light p-3 rounded border">
                                    <code class="text-dark">
                                        "pizza", "pizza, margherita, pepperoni"<br>
                                        "cola", "cola, coke, soft drink"<br>
                                        "one", "one, 1, single"
                                    </code>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="text-primary mb-3">Usage Instructions:</h6>
                            <ol class="ps-3">
                                <li class="mb-2">Download the CSV file for the entity type you need</li>
                                <li class="mb-2">Import the CSV into your Google Dialogflow agent</li>
                                <li class="mb-2">Use the entity in your intents and training phrases</li>
                                <li class="mb-2">Update the CSV and re-import when your data changes</li>
                            </ol>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
.export-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.export-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.export-card .btn {
    transition: all 0.3s ease;
}

.export-card:hover .btn {
    transform: scale(1.05);
}

.avatar-sm {
    width: 40px;
    height: 40px;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

.card {
    border-radius: 12px;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.page-title-box {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.page-title-box h4,
.page-title-box p,
.page-title-box .breadcrumb-item a {
    color: white;
}

.page-title-box .breadcrumb-item.active {
    color: rgba(255,255,255,0.8);
}

@media (max-width: 768px) {
    .page-title-box {
        padding: 1rem;
    }
    
    .page-title-box .d-flex {
        flex-direction: column;
        text-align: center;
    }
    
    .page-title-right {
        margin-top: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .export-card .d-flex {
        flex-direction: column;
        text-align: center;
    }
    
    .export-card .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding: 0.5rem;
    }
    
    .card {
        margin-bottom: 1rem;
    }
}

.stat-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    padding: 1.5rem 1rem;
    margin-bottom: 1rem;
    transition: box-shadow 0.2s;
}
.stat-card:hover {
    box-shadow: 0 6px 24px rgba(0,0,0,0.08);
}
.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 0.5rem auto;
}
.stat-value {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}
.stat-label {
    font-size: 0.95rem;
    color: #888;
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Add click animation to export cards
    $('.export-card').on('click', function(e) {
        if (!$(e.target).hasClass('btn')) {
            $(this).addClass('clicked');
            setTimeout(() => {
                $(this).removeClass('clicked');
            }, 200);
        }
    });

    // Add loading state to download buttons
    $('.export-card .btn').on('click', function() {
        const $btn = $(this);
        const originalText = $btn.html();
        
        $btn.html('<i class="ri-loader-4-line me-1 animate-spin"></i> Downloading...');
        $btn.prop('disabled', true);
        
        setTimeout(() => {
            $btn.html(originalText);
            $btn.prop('disabled', false);
        }, 2000);
    });
});

function showInstructions() {
    $('#instructionsModal').modal('show');
}

function downloadAll() {
    // Show confirmation dialog
    Swal.fire({
        title: 'Download All Entities?',
        text: 'This will download all entity CSV files. Continue?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, download all!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Download each file sequentially
            const downloads = [
                { name: 'Menu Categories', url: '{{ route("admin.dialogflow.export.menu-categories") }}' },
                { name: 'Menu Items', url: '{{ route("admin.dialogflow.export.menu-items") }}' },
                { name: 'FAQ Topics', url: '{{ route("admin.dialogflow.export.faq-topics") }}' },
                { name: 'Quantities', url: '{{ route("admin.dialogflow.export.quantities") }}' },
                { name: 'Status Types', url: '{{ route("admin.dialogflow.export.status-types") }}' },
                { name: 'Date/Time', url: '{{ route("admin.dialogflow.export.datetime") }}' },
                { name: 'Party Size', url: '{{ route("admin.dialogflow.export.party-size") }}' },
                { name: 'Names', url: '{{ route("admin.dialogflow.export.names") }}' },
                { name: 'Emails', url: '{{ route("admin.dialogflow.export.emails") }}' },
                { name: 'Phones', url: '{{ route("admin.dialogflow.export.phones") }}' }
            ];
            
            downloads.forEach((download, index) => {
                setTimeout(() => {
                    const link = document.createElement('a');
                    link.href = download.url;
                    link.download = download.name.toLowerCase().replace(' ', '-') + '.csv';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }, index * 500);
            });
            
            Swal.fire(
                'Downloads Started!',
                'All entity files are being downloaded.',
                'success'
            );
        }
    });
}

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .export-card.clicked {
        transform: scale(0.95);
    }
    
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-subtle { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-subtle { background-color: rgba(255, 193, 7, 0.1); }
    .bg-info-subtle { background-color: rgba(13, 202, 240, 0.1); }
    .bg-secondary-subtle { background-color: rgba(108, 117, 125, 0.1); }
    .bg-dark-subtle { background-color: rgba(33, 37, 41, 0.1); }
    .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.1); }
    
    .text-primary { color: #0d6efd !important; }
    .text-success { color: #198754 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-info { color: #0dcaf0 !important; }
    .text-secondary { color: #6c757d !important; }
    .text-dark { color: #212529 !important; }
    .text-danger { color: #dc3545 !important; }
`;
document.head.appendChild(style);
</script>
@endsection 