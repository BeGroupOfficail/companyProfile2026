<x-dashboard.layout :title="__('dash.contactUs')">

    <!--begin::Card-->
    <div class="card shadow-sm">
        <!--begin::Card header-->
        <div class="card-header border-0 mb-3 pt-6">
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                    <input type="text" id="searchInput" class="form-control form-control-solid w-250px ps-12"
                        placeholder="{{ __('dash.search') }}">
                    <button type="button" id="clearSearch"
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2 d-none">
                        <i class="ki-outline ki-cross fs-2"></i>
                    </button>
                    <div class="spinner-border spinner-border-sm text-primary ms-2 d-none" id="searchSpinner"></div>
                </div>
                <!--end::Search-->
            </div>
            <div class="card-toolbar d-flex justify-content-end align-items-center gap-2">
                <!-- Total Count -->
                <span class="badge badge-light-primary fs-7" id="totalCount">
                    {{ __('dash.total_messages') }} {{ $messages->count() }}
                </span>

                <!-- Filter Buttons -->
                <a href="{{ route('contact-us.index', ['status' => 1]) }}"
                    class="btn btn-sm btn-success {{ request('status') == '1' ? 'active' : '' }}">
                    {{ __('dash.seen') }}
                </a>

                <a href="{{ route('contact-us.index', ['status' => 0]) }}"
                    class="btn btn-sm btn-warning {{ request('status') == '0' ? 'active' : '' }}">
                    {{ __('dash.not_seen') }}
                </a>

                <a href="{{ route('contact-us.index') }}"
                    class="btn btn-sm btn-secondary {{ request('status') == null ? 'active' : '' }}">
                    {{ __('dash.all') }}
                </a>
            </div>

        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            @if ($messages->count() > 0)
                <!--begin::Messages List-->
                <div class="row g-6 g-xl-9 mb-6 mb-xl-9" id="messagesContainer">
                    @foreach ($messages as $message)
                        <!--begin::Message Card-->
                        <div class="col-sm-12 col-md-6 col-lg-6" id="item_{{ $message->id }}">
                            <div
                                class="card card-flush h-xl-100 {{ !$message->seen ? 'border-primary border-dashed' : 'border-gray-300' }}">
                                <!--begin::Card header-->
                                <div class="card-header pt-7">
                                    <div class="card-title d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="symbol symbol-45px me-5">
                                                <div
                                                    class="symbol-label bg-light-{{ $message->seen ? 'info' : 'success' }}">
                                                    <i
                                                        class="ki-outline ki-user fs-2 text-{{ $message->seen ? 'info' : 'success' }}"></i>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h3 class="fs-4 fw-bold text-gray-900 text-hover-primary mb-1">
                                                    {{ $message->name }}</h3>
                                                <div class="fs-6 fw-semibold text-gray-400">
                                                    {{ $message->created_at->translatedFormat('d F Y') }}
                                                    {{ __('dash.at') }} {{ $message->created_at->format('H:i') }}
                                                    <i class="ki-outline ki-calendar fs-7 me-1"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-3">
                                            <span
                                                class="badge badge-light-primary me-auto">{{ $message->title }}</span>
                                            @if (!$message->seen)
                                                <span class="badge badge-success">{{ __('dash.new') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card header-->

                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <div class="mb-5">
                                        <h6 class="text-muted fw-semibold fs-7 text-uppercase mb-3">
                                            {{ __('dash.reason for connect') }}</h6>
                                        <p class="text-gray-800 fw-normal fs-6 lh-lg mb-0">{{ $message->message }}</p>
                                    </div>

                                    <div class="row mb-5">
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-phone fs-4 text-muted me-3"></i>
                                                <div>
                                                    <span class="text-muted fs-7 d-block">{{ __('dash.phone') }}</span>
                                                    {{ $message->phone }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-message fs-4 text-muted me-3"></i>
                                                <div>
                                                    <span class="text-muted fs-7 d-block">{{ __('dash.email') }}</span>
                                                    <a href="mailto:{{ $message->email }}"
                                                        class="text-gray-800 fs-6 fw-semibold text-hover-primary">{{ $message->email }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-stack">
                                        <div class="d-flex align-items-center">
                                            <span class="text-muted fs-8">
                                                <i class="ki-outline ki-time fs-8 me-1"></i>
                                                {{ $message->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <div class="d-flex">
                                            @if ($message->seen)
                                                <a class="badge border border-info text-info bg-transparent me-2">
                                                    <i class="ki-outline ki-check fs-6 me-1"></i>
                                                    {{ __('dash.seen') }}
                                                </a>
                                            @else
                                                <a class="btn btn-sm btn-light-primary me-2"
                                                    href="{{ route('contact-us.show', $message) }}">
                                                    <i class="ki-outline ki-check fs-6 me-1"></i>
                                                    {{ __('dash.mark_as_read') }}
                                                </a>
                                            @endif
                                            <button class="btn btn-sm btn-light-danger delete_me_contact"
                                                data-delete_route="{{ route('contact-us.destroy', $message->id) }}">
                                                <i class="ki-outline ki-trash fs-6 me-1"></i>
                                                {{ __('dash.delete') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card body-->
                            </div>
                        </div>
                        <!--end::Message Card-->
                    @endforeach
                </div>

                <div id="emptyState" class="d-none text-center p-10">
                    <div class="card-px text-center pt-15 pb-15">
                        <h2 id="emptyStateTitle" class="fs-2x fw-bold mb-0"></h2>
                        <p id="emptyStateMessage" class="text-gray-400 fs-4 fw-semibold py-7"></p>
                        <i id="emptyStateIcon" class="fs-4x opacity-50"></i>
                    </div>
                </div>

                <div id="paginationContainer"></div>
            @else
                <div class="d-flex flex-column flex-center text-center p-10" id="emptyState">
                    <div class="card-px text-center pt-15 pb-15">
                        <h2 class="fs-2x fw-bold mb-0">{{ __('dash.no_messages') }}</h2>
                        <p class="text-gray-400 fs-4 fw-semibold py-7">
                            {{ __('dash.no_contact_messages_yet') }}
                            <br>{{ __('dash.messages_will_appear_here') }}
                        </p>
                        <i class="ki-outline ki-message-question fs-4x opacity-50"></i>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let searchTimeout;
                let allMessages = [];
                let filteredMessages = [];
                let currentPage = 1;
                const itemsPerPage = 10;

                const searchInput = document.getElementById('searchInput');
                const clearSearchBtn = document.getElementById('clearSearch');
                const searchSpinner = document.getElementById('searchSpinner');
                const messagesContainer = document.getElementById('messagesContainer');
                const paginationContainer = document.getElementById('paginationContainer');
                const totalCount = document.getElementById('totalCount');

                function initializeMessages() {
                    const messageCards = document.querySelectorAll('#messagesContainer > div');
                    allMessages = Array.from(messageCards).map((card, index) => {
                        const nameEl = card.querySelector('h3');
                        const emailEl = card.querySelector('a[href^="mailto:"]');
                        const phoneEl = card.querySelector('.ki-phone')?.nextElementSibling;
                        const titleEl = card.querySelector('.badge-light-primary');
                        const messageEl = card.querySelector('.text-gray-800.fw-normal');

                        return {
                            index: index,
                            element: card,
                            searchText: (
                                (nameEl?.textContent || '') + ' ' +
                                (emailEl?.textContent || '') + ' ' +
                                (phoneEl?.textContent || '') + ' ' +
                                (titleEl?.textContent || '') + ' ' +
                                (messageEl?.textContent || '')
                            ).toLowerCase()
                        };
                    });

                    filteredMessages = allMessages;
                    showPage(1);
                }

                function filterMessages(query) {
                    if (!query) return allMessages;
                    return allMessages.filter(m => m.searchText.includes(query.toLowerCase()));
                }

                function showPage(page) {
                    currentPage = page;
                    allMessages.forEach(m => (m.element.style.display = 'none'));

                    const start = (page - 1) * itemsPerPage;
                    const end = start + itemsPerPage;
                    const visible = filteredMessages.slice(start, end);
                    visible.forEach(m => (m.element.style.display = 'block'));

                    totalCount.textContent = '{{ __('dash.total_messages') }} ' + filteredMessages.length;
                    generatePagination(filteredMessages.length, page);
                }

                function generatePagination(total, page) {
                    const totalPages = Math.ceil(total / itemsPerPage);
                    if (totalPages <= 1) {
                        paginationContainer.innerHTML = '';
                        return;
                    }

                    let html = `<ul class="pagination justify-content-center mt-5">`;
                    for (let i = 1; i <= totalPages; i++) {
                        html += `<li class="page-item ${i === page ? 'active' : ''}">
                        <a href="#" class="page-link pagination-link" data-page="${i}">${i}</a>
                    </li>`;
                    }
                    html += `</ul>`;
                    paginationContainer.innerHTML = html;
                }

                function performSearch(query = '') {
                    searchSpinner.classList.remove('d-none');
                    setTimeout(() => {
                        filteredMessages = filterMessages(query);
                        showPage(1);
                        searchSpinner.classList.add('d-none');
                    }, 200);
                }

                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();
                    clearSearchBtn.classList.toggle('d-none', query === '');
                    searchTimeout = setTimeout(() => performSearch(query), 300);
                });

                clearSearchBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    this.classList.add('d-none');
                    performSearch('');
                });

                paginationContainer.addEventListener('click', e => {
                    if (e.target.closest('.pagination-link')) {
                        e.preventDefault();
                        const page = parseInt(e.target.dataset.page);
                        showPage(page);
                    }
                });

                initializeMessages();
            });
        </script>

        <script>
            $(document).on('click', '.delete_me_contact', function(e) {
                e.preventDefault();
                let deleteRoute = $(this).data('delete_route');
                let row = $(this).closest('tr'); // Get the row to remove it later
                let id = deleteRoute.split('/').pop();
                var selectedIds = [];
                selectedIds.push(id);
                Swal.fire({
                    title: "{{ __('dash.are you sure?') }}",
                    text: "{{ __('dash.delete this records') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "{{ __('dash.yes, delete it!') }}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteRoute,
                            type: 'DELETE',
                            data: {
                                selectedIds: selectedIds
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "{{ __('dash.deleted') }}",
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    $('#item_' + id).fadeOut(500, function() {
                                        $(this).remove();
                                    });
                                    const totalCount = document.getElementById('totalCount');
                                    let text = totalCount.textContent;

                                    // Extract the first number in the text
                                    let numberMatch = text.match(/\d+/);

                                    if (numberMatch) {
                                        let currentCount = parseInt(numberMatch[0]);
                                        let newCount = currentCount - 1;
                                        if (newCount < 0) newCount = 0; // prevent negative numbers

                                        // Replace the old number with the new one
                                        totalCount.textContent = text.replace(/\d+/, newCount);
                                    }

                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "{{ __('dash.error') }}",
                                        text: "{{ __('dash.error_delete') }}"
                                    });
                                }
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: "{{ __('dash.error') }}",
                                    text: error.responseJSON?.message ||
                                        "An unexpected error occurred.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
        </script>
    @endpush

</x-dashboard.layout>
