// ============================================================================
// public/js/deleted-records.js - Complete JavaScript (~400 lines)
// ============================================================================

const DeletedRecords = (function() {
    'use strict';

    // Private variables
    let currentPage = 1;
    const config = window.deletedRecordsConfig || {};

    // ========================================================================
    // Initialization
    // ========================================================================
    function init() {
        currentPage = config.initialPage || 1;
        initTooltips();
        bindEvents();
        updateSelectedCount();
    }

    function initTooltips() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    // ========================================================================
    // Event Binding
    // ========================================================================
    function bindEvents() {
        // Filter events
        $('#model-filter').on('change', handleFilterChange);
        $(document).on('click', '#clear-filter', handleClearFilter);
        
        // Pagination
        $(document).on('click', '.pagination-link', handlePaginationClick);
        
        // Checkboxes
        $(document).on('change', '#select-all', handleSelectAll);
        $(document).on('change', '.record-checkbox', handleIndividualCheckbox);
        
        // Actions
        $(document).on('click', '.btn-view-details', handleViewDetails);
        $(document).on('click', '.btn-restore', handleBulkRestore);
        $(document).on('click', '.btn-force-delete', handleBulkDelete);
        $(document).on('click', '.btn-restore-single', handleSingleRestore);
        $(document).on('click', '.btn-force-delete-single', handleSingleDelete);
    }

    // ========================================================================
    // Event Handlers
    // ========================================================================
    function handleFilterChange(e) {
        const selectedModel = $(e.target).val() || 'all';
        currentPage = 1;
        updateURL(selectedModel, currentPage);
        loadRecords(selectedModel, currentPage);
    }

    function handleClearFilter() {
        window.location.href = config.routes.index + '?model=all';
    }

    function handlePaginationClick(e) {
        e.preventDefault();
        currentPage = $(e.currentTarget).data('page');
        const model = $('#model-filter').val() || 'all';
        updateURL(model, currentPage);
        loadRecords(model, currentPage);
        $('html, body').animate({ scrollTop: 0 }, 'smooth');
    }

    function handleSelectAll(e) {
        $('.record-checkbox').prop('checked', $(e.target).prop('checked'));
        updateSelectedCount();
    }

    function handleIndividualCheckbox() {
        updateSelectedCount();
        const total = $('.record-checkbox').length;
        const checked = $('.record-checkbox:checked').length;
        $('#select-all').prop('checked', total > 0 && checked === total);
    }

    function handleViewDetails(e) {
        e.preventDefault();
        const recordId = $(e.currentTarget).data('id');
        const modelType = $(e.currentTarget).data('model');
        showDetailsModal(recordId, modelType);
    }

    function handleBulkRestore(e) {
        e.preventDefault();
        const records = getSelectedRecords();
        if (!validateSelection(records)) return;
        confirmAction('restore', records, true);
    }

    function handleBulkDelete(e) {
        e.preventDefault();
        const records = getSelectedRecords();
        if (!validateSelection(records)) return;
        confirmAction('delete', records, true);
    }

    function handleSingleRestore(e) {
        e.preventDefault();
        const record = [{ 
            id: $(e.currentTarget).data('id'), 
            model: $(e.currentTarget).data('model') 
        }];
        confirmAction('restore', record, false);
    }

    function handleSingleDelete(e) {
        e.preventDefault();
        const record = [{ 
            id: $(e.currentTarget).data('id'), 
            model: $(e.currentTarget).data('model') 
        }];
        confirmAction('delete', record, false);
    }

    // ========================================================================
    // Data Operations
    // ========================================================================
    function loadRecords(model = 'all', page = 1) {
        showLoading(true);

        $.ajax({
            url: config.routes.filter,
            type: 'GET',
            data: { model, page },
            success: function(response) {
                renderRecords(response.records, model);
                renderPagination(response.pagination);
                showLoading(false);
                initTooltips();
            },
            error: function() {
                showLoading(false);
                toastr.error('An error occurred while loading records');
            }
        });
    }

    function performAction(action, records) {
        const url = action === 'restore' ? config.routes.restore : config.routes.forceDelete;
        showLoading(true);

        $.ajax({
            url,
            type: 'POST',
            data: {
                records,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                showLoading(false);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    const selectedModel = $('#model-filter').val() || 'all';
                    loadRecords(selectedModel, currentPage);
                } else {
                    showError(response.message);
                }
            },
            error: function() {
                showLoading(false);
                showError('An error occurred');
            }
        });
    }

    function showDetailsModal(recordId, modelType) {
        $('#detailsModal').modal('show');
        $('#detailsModalBody').html(getLoadingHTML());

        $.ajax({
            url: config.routes.details,
            type: 'GET',
            data: { id: recordId, model: modelType },
            success: function(response) {
                if (response.success) {
                    renderDetails(response.data);
                } else {
                    showModalError(response.message || 'Unable to load details');
                }
            },
            error: function() {
                showModalError('An error occurred while loading details');
            }
        });
    }

    // ========================================================================
    // Rendering Functions
    // ========================================================================
    function renderRecords(records, selectedModel) {
        const html = records.length > 0 
            ? buildTableHTML(records)
            : buildEmptyStateHTML(selectedModel);
        
        $('#records-container').html(html);
        updateSelectedCount();
    }

    function buildTableHTML(records) {
        let rows = '';
        records.forEach(record => {
            const modelName = record.model_display_name || record.model_type.split('\\').pop();
            const deletedByName = record.deleted_by_name || 'Unknown';
            const deletedByInitial = deletedByName.charAt(0).toUpperCase();

            rows += `
                <tr>
                    <td class="ps-4">
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input record-checkbox" type="checkbox"
                                data-id="${record.id}" data-model="${record.model_type}">
                        </div>
                    </td>
                    <td><span class="badge badge-light-primary fs-7 fw-bold">${modelName}</span></td>
                    <td><span class="text-dark fw-bold">#${record.model_id}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-25px me-2">
                                <span class="symbol-label bg-light-success text-success fw-bold">${deletedByInitial}</span>
                            </div>
                            <span class="text-gray-800">${deletedByName}</span>
                        </div>
                    </td>
                    <td>
                        <span class="text-muted">${formatRelativeDate(record.created_at)}</span><br>
                        <span class="text-muted fs-8">${formatAbsoluteDate(record.created_at)}</span>
                    </td>
                    <td class="text-end pe-4">
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-view-details"
                            data-id="${record.id}" data-model="${record.model_type}" data-bs-toggle="tooltip" title="View Details">
                            <i class="ki-outline ki-eye fs-3"></i>
                        </a>
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-success btn-sm me-1 btn-restore-single"
                            data-id="${record.id}" data-model="${record.model_type}" data-bs-toggle="tooltip" title="Restore">
                            <i class="ki-outline ki-arrow-circle-left fs-3"></i>
                        </a>
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn-force-delete-single"
                            data-id="${record.id}" data-model="${record.model_type}" data-bs-toggle="tooltip" title="Delete Permanently">
                            <i class="ki-outline ki-trash fs-3"></i>
                        </a>
                    </td>
                </tr>`;
        });

        return `
            <div class="table-responsive">
                <table id="deleted-records-table" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="w-25px ps-4">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="select-all">
                                </div>
                            </th>
                            <th class="min-w-150px">Model Type</th>
                            <th class="min-w-100px">Model ID</th>
                            <th class="min-w-150px">Deleted By</th>
                            <th class="min-w-150px">Deleted At</th>
                            <th class="text-end min-w-150px pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">${rows}</tbody>
                </table>
            </div>
            <div class="d-flex flex-wrap gap-3 mt-5 pt-5 border-top">
                <button class="btn btn-success btn-restore">
                    <i class="ki-outline ki-arrow-circle-left fs-3"></i> Restore Selected
                </button>
                <button class="btn btn-danger btn-force-delete">
                    <i class="ki-outline ki-trash fs-3"></i> Delete Selected Permanently
                </button>
                <div class="ms-auto">
                    <span class="text-muted fs-7" id="selected-count">0 items selected</span>
                </div>
            </div>`;
    }

    function buildEmptyStateHTML(selectedModel) {
        const message = selectedModel === 'all' 
            ? 'No deleted records found'
            : 'No deleted records found for this model';
        
        return `
            <div class="card bg-light-info">
                <div class="card-body d-flex align-items-center py-8">
                    <i class="ki-duotone ki-information-5 fs-3x text-info me-5">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                    <div class="flex-grow-1">
                        <h4 class="text-gray-900 fw-bold mb-1">${message}</h4>
                        <div class="text-gray-700">All records are active or permanently deleted</div>
                    </div>
                </div>
            </div>`;
    }

    function renderPagination(pagination) {
        if (pagination.last_page <= 1) {
            $('#pagination-container').remove();
            return;
        }

        const start = Math.max(pagination.current_page - 2, 1);
        const end = Math.min(start + 4, pagination.last_page);
        const adjustedStart = Math.max(end - 4, 1);

        let html = `
            <div id="pagination-container" class="d-flex flex-stack flex-wrap pt-10">
                <div class="fs-6 fw-semibold text-gray-700">
                    Showing <span class="fw-bold">${pagination.from}</span> to 
                    <span class="fw-bold">${pagination.to}</span> of 
                    <span class="fw-bold">${pagination.total}</span> results
                </div>
                <ul class="pagination">`;

        // Previous
        html += pagination.current_page === 1
            ? '<li class="page-item previous disabled"><a href="#" class="page-link"><i class="previous"></i></a></li>'
            : `<li class="page-item previous"><a href="#" class="page-link pagination-link" data-page="${pagination.current_page - 1}"><i class="previous"></i></a></li>`;

        // First + ellipsis
        if (adjustedStart > 1) {
            html += '<li class="page-item"><a href="#" class="page-link pagination-link" data-page="1">1</a></li>';
            if (adjustedStart > 2) {
                html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        // Pages
        for (let i = adjustedStart; i <= end; i++) {
            html += i === pagination.current_page
                ? `<li class="page-item active"><span class="page-link">${i}</span></li>`
                : `<li class="page-item"><a href="#" class="page-link pagination-link" data-page="${i}">${i}</a></li>`;
        }

        // Ellipsis + last
        if (end < pagination.last_page) {
            if (end < pagination.last_page - 1) {
                html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            html += `<li class="page-item"><a href="#" class="page-link pagination-link" data-page="${pagination.last_page}">${pagination.last_page}</a></li>`;
        }

        // Next
        html += pagination.current_page === pagination.last_page
            ? '<li class="page-item next disabled"><a href="#" class="page-link"><i class="next"></i></a></li>'
            : `<li class="page-item next"><a href="#" class="page-link pagination-link" data-page="${pagination.current_page + 1}"><i class="next"></i></a></li>`;

        html += '</ul></div>';

        $('#pagination-container').remove();
        $('#records-container').append(html);
    }

    function renderDetails(data) {
        let html = `
            <div class="card bg-light mb-5">
                <div class="card-body">
                    <div class="row g-5">
                        <div class="col-md-3">
                            <label class="fw-bold text-muted mb-1">Model</label>
                            <div class="fs-6 fw-bold text-gray-800">${data.model_name || '-'}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="fw-bold text-muted mb-1">Model ID</label>
                            <div class="fs-6 fw-bold text-gray-800">#${data.data.id || '-'}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="fw-bold text-muted mb-1">Deleted By</label>
                            <div class="fs-6 fw-bold text-gray-800">${data.data._deleted_by || '-'}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="fw-bold text-muted mb-1">Time</label>
                            <div class="fs-6 fw-bold text-gray-800">${data.data._deleted_at || '-'}</div>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="mb-4">Record Details</h5>`;

        if (data.data && typeof data.data === 'object') {
            html += '<div class="table-responsive"><table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">';
            html += '<thead><tr class="fw-bold text-muted bg-light"><th class="w-250px">Field</th><th>Value</th></tr></thead><tbody class="fw-semibold text-gray-600">';
            
            Object.keys(data.data).forEach(key => {
                if (key === '_deleted_at' || key === '_deleted_by') return;
                const formattedKey = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                const value = formatValue(data.data[key]);
                html += `<tr><td><span class="text-gray-800 fw-bold">${formattedKey}</span></td><td>${value}</td></tr>`;
            });
            
            html += '</tbody></table></div>';
        } else {
            html += '<div class="alert alert-secondary">No data available</div>';
        }

        $('#detailsModalBody').html(html);
    }

    // ========================================================================
    // Helper Functions
    // ========================================================================
    function getSelectedRecords() {
        const records = [];
        $('.record-checkbox:checked').each(function() {
            records.push({ id: $(this).data('id'), model: $(this).data('model') });
        });
        return records;
    }

    function validateSelection(records) {
        if (records.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one record',
                confirmButtonText: 'OK'
            });
            return false;
        }
        return true;
    }

    function confirmAction(action, records, isBulk) {
        const isRestore = action === 'restore';
        const title = isBulk 
            ? (isRestore ? 'Restore Records' : 'Permanent Delete')
            : (isRestore ? 'Restore Record' : 'Permanent Delete');
        const text = isBulk
            ? (isRestore ? 'Are you sure you want to restore these records?' : 'Are you sure you want to permanently delete these records? This action cannot be undone!')
            : (isRestore ? 'Are you sure you want to restore this record?' : 'Are you sure you want to permanently delete this record? This action cannot be undone!');

        Swal.fire({
            title,
            text,
            icon: isRestore ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonText: isBulk ? (isRestore ? 'Restore Selected' : 'Delete Selected Permanently') : (isRestore ? 'Restore' : 'Delete'),
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            confirmButtonColor: isRestore ? '#50cd89' : '#f1416c'
        }).then(result => {
            if (result.isConfirmed) {
                performAction(action, records);
            }
        });
    }

    function updateSelectedCount() {
        const count = $('.record-checkbox:checked').length;
        $('#selected-count').text(count + ' items selected');
    }

    function updateURL(model, page) {
        const url = new URL(window.location);
        url.searchParams.set('model', model || 'all');
        page > 1 ? url.searchParams.set('page', page) : url.searchParams.delete('page');
        window.history.pushState({}, '', url);
    }

    function showLoading(show) {
        if (show) {
            $('#loading-spinner').show();
            $('#records-container').css('opacity', '0.5');
        } else {
            $('#loading-spinner').hide();
            $('#records-container').css('opacity', '1');
        }
    }

    function showError(message) {
        Swal.fire({ icon: 'error', title: 'Error', text: message || 'An error occurred' });
    }

    function showModalError(message) {
        $('#detailsModalBody').html(`
            <div class="alert alert-danger d-flex align-items-center">
                <i class="ki-duotone ki-cross-circle fs-2hx text-danger me-4">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <div>${message}</div>
            </div>`);
    }

    function getLoadingHTML() {
        return `
            <div class="text-center py-10">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-3">Loading details...</p>
            </div>`;
    }

    function formatValue(value) {
        if (value === null || value === '') return '<span class="text-muted fst-italic">NULL</span>';
        if (typeof value === 'boolean') return value ? '<span class="badge badge-light-success">Yes</span>' : '<span class="badge badge-light-secondary">No</span>';
        if (typeof value === 'object') return `<pre class="bg-light p-3 rounded mb-0" style="font-size: 0.85rem; max-height: 200px; overflow-y: auto;">${JSON.stringify(value, null, 2)}</pre>`;
        return value;
    }

    function formatRelativeDate(dateString) {
        const seconds = Math.floor((new Date() - new Date(dateString)) / 1000);
        const intervals = { year: 31536000, month: 2592000, day: 86400, hour: 3600, minute: 60 };
        
        for (const [unit, secondsInUnit] of Object.entries(intervals)) {
            const interval = Math.floor(seconds / secondsInUnit);
            if (interval >= 1) return `${interval} ${unit}${interval > 1 ? 's' : ''} ago`;
        }
        return `${seconds} second${seconds !== 1 ? 's' : ''} ago`;
    }

    function formatAbsoluteDate(dateString) {
        const date = new Date(dateString);
        return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')} ${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
    }

    // ========================================================================
    // Public API
    // ========================================================================
    return { init };
})();

// Initialize on document ready
$(document).ready(function() {
    DeletedRecords.init();
});