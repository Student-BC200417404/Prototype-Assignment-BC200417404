/**
 * CRUD Operations JavaScript
 * Handles AJAX form submissions and SweetAlert delete confirmations
 * Compatible with existing admin layout
 */

// Global variable to store DataTable instances
window.dataTableInstances = {};

$(document).ready(function() {
    // Initialize DataTables (only if not already initialized)
    initializeDataTables();
    
    // Initialize form submissions
    initializeFormSubmissions();
    
    // Initialize delete confirmations
    initializeDeleteConfirmations();
    
    // Initialize status updates
    initializeStatusUpdates();
    
    // Initialize image previews
    initializeImagePreview();
    
    // Initialize select2
    initializeSelect2();
    
    // Initialize date pickers
    initializeDatePickers();
    
    // Initialize time pickers
    initializeTimePickers();
    
    // Initialize rich text editors
    initializeRichTextEditors();
});

/**
 * Initialize DataTables with AJAX
 */
function initializeDataTables() {
    $('.datatable').each(function() {
        const table = $(this);
        const tableId = table.attr('id') || 'datatable_' + Math.random().toString(36).substr(2, 9);
        
        // Set table ID if not already set
        if (!table.attr('id')) {
            table.attr('id', tableId);
        }
        
        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable(table)) {
            return; // Skip if already initialized
        }
        
        // Default configuration
        const config = {
            processing: true,
            serverSide: true,
            ajax: table.data('url'),
            responsive: true,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries per page",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                processing: "Processing...",
                emptyTable: "No data available in table",
                zeroRecords: "No matching records found"
            },
            drawCallback: function() {
                // Reinitialize tooltips after table redraw
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        };
        // Add explicit columns and default order for menu-datatable
        if (tableId === 'menu-datatable' || table.attr('id') === 'menu-datatable') {
            config.columns = [
                { data: 'checkbox', orderable: false, searchable: false },
                { data: 'id' },
                { data: 'image' },
                { data: 'name' },
                { data: 'category_name' },
                { data: 'price_formatted' },
                { data: 'status' },
                { data: 'features' },
                { data: 'created_at' },
                { data: 'action', orderable: false, searchable: false }
            ];
            config.order = [[1, 'asc']]; // Order by ID ascending
        }
        try {
            // Initialize DataTable
            const dataTable = table.DataTable(config);
            
            // Store the instance globally
            window.dataTableInstances[tableId] = dataTable;
            
            console.log('DataTable initialized successfully for:', tableId);
        } catch (error) {
            console.error('Error initializing DataTable for:', tableId, error);
        }
    });
}

/**
 * Get DataTable instance by selector
 */
function getDataTable(tableSelector = '.datatable') {
    const table = $(tableSelector);
    const tableId = table.attr('id');
    
    if (tableId && window.dataTableInstances[tableId]) {
        return window.dataTableInstances[tableId];
    }
    
    // Fallback to direct DataTable check
    if ($.fn.DataTable.isDataTable(table)) {
        return table.DataTable();
    }
    
    return null;
}

/**
 * Reload DataTable safely
 */
function reloadDataTable(tableSelector = '.datatable') {
    const dataTable = getDataTable(tableSelector);
    if (dataTable) {
        dataTable.ajax.reload();
    } else {
        console.warn('DataTable not found for selector:', tableSelector);
    }
}

/**
 * Destroy DataTable safely
 */
function destroyDataTable(tableSelector = '.datatable') {
    const table = $(tableSelector);
    const tableId = table.attr('id');
    
    if (tableId && window.dataTableInstances[tableId]) {
        window.dataTableInstances[tableId].destroy();
        delete window.dataTableInstances[tableId];
    } else if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().destroy();
    }
}

/**
 * Clear all DataTable instances
 */
function clearAllDataTables() {
    Object.keys(window.dataTableInstances).forEach(function(tableId) {
        if (window.dataTableInstances[tableId]) {
            window.dataTableInstances[tableId].destroy();
        }
    });
    window.dataTableInstances = {};
}

/**
 * Initialize AJAX form submissions
 */
function initializeFormSubmissions() {
    // Handle form submissions with AJAX
    $('form[data-ajax="true"]').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.text();
        const originalHtml = submitBtn.html();
        
        // Show loading state
        submitBtn.prop('disabled', true).html('<i class="ri-loader-4-line ri-spin"></i> Processing...');
        
        // Get form data
        const formData = new FormData(this);
        
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Operation completed successfully!',
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    // Redirect if specified
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        window.location.reload();
                    }
                });
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        // Handle validation errors
                        const errors = xhr.responseJSON.errors;
                        const errorList = Object.values(errors).flat().join('<br>');
                        errorMessage = errorList;
                        
                        // Show validation errors in form
                        showValidationErrors(form, errors);
                    }
                }
                
                // Log error to server
                logErrorToServer('Form submission error', {
                    url: form.attr('action'),
                    method: form.attr('method'),
                    status: xhr.status,
                    response: xhr.responseText
                });
                
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: errorMessage
                });
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false).html(originalHtml);
            }
        });
    });
}

/**
 * Initialize delete confirmations with SweetAlert
 */
function initializeDeleteConfirmations() {
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        
        const id = $(this).data('id');
        const url = $(this).data('url') || $(this).closest('tr').data('delete-url');
        const itemName = $(this).data('name') || 'this item';
        
        Swal.fire({
            title: 'Are you sure?',
            text: `You want to delete ${itemName}? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteItem(id, url);
            }
        });
    });
}

/**
 * Delete item via AJAX
 */
function deleteItem(id, url) {
    $.ajax({
        url: url || `/admin/${getCurrentModule()}/${id}`,
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: response.message || 'Item has been deleted successfully.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    // Reload DataTable safely
                    reloadDataTable();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message || 'Failed to delete item.'
                });
            }
        },
        error: function(xhr) {
            let errorMessage = 'An error occurred while deleting the item.';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            // Log error to server
            logErrorToServer('Delete operation error', {
                url: url,
                id: id,
                status: xhr.status,
                response: xhr.responseText
            });
            
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: errorMessage
            });
        }
    });
}

/**
 * Initialize status updates
 */
function initializeStatusUpdates() {
    $(document).on('click', '.status-toggle', function(e) {
        e.preventDefault();
        
        const id = $(this).data('id');
        const currentStatus = $(this).data('status');
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        
        $.ajax({
            url: `/admin/${getCurrentModule()}/${id}/toggle-status`,
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    // Update button state
                    const btn = $(`[data-id="${id}"]`);
                    btn.data('status', newStatus);
                    btn.text(newStatus === 'active' ? 'Active' : 'Inactive');
                    btn.removeClass('btn-success btn-danger').addClass(newStatus === 'active' ? 'btn-success' : 'btn-danger');
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message || 'Status updated successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                // Log error to server
                logErrorToServer('Status update error', {
                    url: `/admin/${getCurrentModule()}/${id}/toggle-status`,
                    id: id,
                    status: xhr.status,
                    response: xhr.responseText
                });
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to update status.'
                });
            }
        });
    });
}

/**
 * Show validation errors in form
 */
function showValidationErrors(form, errors) {
    // Clear previous errors
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.invalid-feedback').remove();
    
    // Add new errors
    Object.keys(errors).forEach(function(field) {
        const input = form.find(`[name="${field}"]`);
        if (input.length) {
            input.addClass('is-invalid');
            input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
        }
    });
}

/**
 * Get current module name from URL
 */
function getCurrentModule() {
    const path = window.location.pathname;
    const segments = path.split('/');
    return segments[2] || 'dashboard'; // admin/module/...
}

/**
 * Initialize image preview
 */
function initializeImagePreview() {
    $('input[type="file"][accept*="image"]').on('change', function() {
        const file = this.files[0];
        const preview = $(this).siblings('.image-preview');
        
        if (file && preview.length) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.html(`<img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px;">`);
            };
            reader.readAsDataURL(file);
        }
    });
}

/**
 * Initialize select2 for better dropdowns
 */
function initializeSelect2() {
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
}

/**
 * Initialize date pickers
 */
function initializeDatePickers() {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
    
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: false
    });
}

/**
 * Initialize time pickers
 */
function initializeTimePickers() {
    $('.timepicker').timepicker({
        format: 'HH:mm',
        showMeridian: false
    });
}

/**
 * Initialize rich text editors
 */
function initializeRichTextEditors() {
    $('.rich-editor').each(function() {
        $(this).summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
}

/**
 * Log error to server
 */
function logErrorToServer(message, context) {
    $.ajax({
        url: '/admin/log-error',
        method: 'POST',
        data: {
            message: message,
            context: JSON.stringify(context),
            url: window.location.href,
            user_agent: navigator.userAgent
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).fail(function() {
        // If error logging fails, log to console
        console.error('Error logging failed:', message, context);
    });
}

/**
 * Show loading overlay
 */
function showLoading() {
    if (!$('#loading-overlay').length) {
        $('body').append(`
            <div id="loading-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                 background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">
                <div class="text-white">
                    <i class="ri-loader-4-line ri-spin" style="font-size: 2rem;"></i>
                    <p class="mt-2">Loading...</p>
                </div>
            </div>
        `);
    }
    $('#loading-overlay').show();
}

/**
 * Hide loading overlay
 */
function hideLoading() {
    $('#loading-overlay').hide();
}

/**
 * Format currency
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

/**
 * Format date
 */
function formatDate(date) {
    return moment(date).format('MMM DD, YYYY');
}

/**
 * Format datetime
 */
function formatDateTime(date) {
    return moment(date).format('MMM DD, YYYY HH:mm');
}

/**
 * Validate email
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Validate phone number
 */
function isValidPhone(phone) {
    const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
    return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
}

/**
 * Show confirmation dialog
 */
function showConfirmation(title, text, callback) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed && callback) {
            callback();
        }
    });
}

/**
 * Show notification
 */
function showNotification(title, message, type = 'success') {
    Swal.fire({
        icon: type,
        title: title,
        text: message,
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
} 