<x-dashboard.layout :title="__('dash.home page statistics')">
    <div class="row g-4 m-1">
        <!-- Users Statistics -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate overflow-hidden">
                <div class="position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">@lang('dash.Total Users')</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span class="counter-value" data-target="{{ $statistics['users'] ?? 0 }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                        <i class="ki-outline ki-people"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-dashed py-2">
                        <a href="{{ route('users.users.index') }}" class="text-primary text-decoration-none">
                            @lang('dash.View all users') <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Statistics -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate overflow-hidden">
                <div class="position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">@lang('dash.Total Services')</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span class="counter-value" data-target="{{ $statistics['services'] ?? 0 }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-success-subtle text-success rounded fs-3">
                                        <i class="ki-outline ki-shop"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-dashed py-2">
                        <a href="{{ route('services.index') }}" class="text-success text-decoration-none">
                            @lang('dash.View all services') <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Statistics -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate overflow-hidden">
                <div class="position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">@lang('dash.Total Projects')</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span class="counter-value" data-target="{{ $statistics['projects'] ?? 0 }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                        <i class="ki-outline ki-security-check"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-dashed py-2">
                        <a href="{{ route('projects.index') }}" class="text-info text-decoration-none">
                            @lang('dash.View all projects') <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blogs Statistics -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate overflow-hidden">
                <div class="position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">@lang('dash.Total Blogs')</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span class="counter-value" data-target="{{ $statistics['blogs'] ?? 0 }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded fs-3">
                                        <i class="ki-outline ki-feather"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-dashed py-2">
                        <a href="{{ route('blogs.index') }}" class="text-warning text-decoration-none">
                            @lang('dash.View all blogs') <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clients Statistics -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate overflow-hidden">
                <div class="position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">@lang('dash.Total Clients')</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span class="counter-value" data-target="{{ $statistics['clients'] ?? 0 }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-danger-subtle text-danger rounded fs-3">
                                        <i class="ki-outline ki-bookmark-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-dashed py-2">
                        <a href="{{ route('clients.index') }}" class="text-danger text-decoration-none">
                            @lang('dash.View all clients') <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Statistics -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate overflow-hidden">
                <div class="position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">@lang('dash.Total Testimonials')</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span class="counter-value" data-target="{{ $statistics['testimonials'] ?? 0 }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-secondary-subtle text-secondary rounded fs-3">
                                        <i class="ki-outline ki-crown-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-dashed py-2">
                        <a href="{{ route('testimonials.index') }}" class="text-secondary text-decoration-none">
                            @lang('dash.View all testimonials') <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pages Statistics -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate overflow-hidden">
                <div class="position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">@lang('dash.Total Pages')</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span class="counter-value" data-target="{{ $statistics['pages'] ?? 0 }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-dark-subtle text-dark rounded fs-3">
                                        <i class="ki-outline ki-document"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-dashed py-2">
                        <a href="{{ route('pages.index') }}" class="text-dark text-decoration-none">
                            @lang('dash.View all pages') <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Messages Statistics -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate overflow-hidden">
                <div class="position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">@lang('dash.Contact Messages')</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span class="counter-value" data-target="{{ $statistics['contact_messages'] ?? 0 }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                        <i class="ki-outline ki-messages"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-dashed py-2">
                        <a href="{{ route('contact-us.index') }}" class="text-primary text-decoration-none">
                            @lang('dash.View all messages') <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row g-4 m-1">
        <div class="col-xl-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex border-bottom-dashed">
                    <h4 class="card-title mb-0 flex-grow-1">
                        <i class="ki-outline ki-feather align-middle me-1 text-muted"></i> @lang('dash.Recent Blogs')
                    </h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('blogs.index') }}" class="btn btn-sm btn-soft-primary">
                            @lang('dash.View All') <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0">
                            <tbody>
                                @forelse($recent_blogs ?? [] as $blog)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($blog->image)
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm">
                                                            <img src="{{ asset('uploads/blogs/' . $blog->image) }}" class="img-fluid rounded" alt="">
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ str($blog->title)->limit(40) }}</h6>
                                                    <p class="text-muted mb-0">{{ $blog->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge badge-soft-{{ $blog->status == 'published' ? 'success' : 'warning' }}">
                                                {{ ucfirst($blog->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ki-outline ki-feather fs-1 mb-2"></i>
                                                <p>@lang('dash.No blogs found')</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex border-bottom-dashed">
                    <h4 class="card-title mb-0 flex-grow-1">
                        <i class="ki-outline ki-messages align-middle me-1 text-muted"></i> @lang('dash.Recent Contact Messages')
                    </h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('contact-us.index') }}" class="btn btn-sm btn-soft-primary">
                            @lang('dash.View All') <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0">
                            <tbody>
                                @forelse($recent_messages ?? [] as $message)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-sm">
                                                        <div class="avatar-title bg-light text-primary rounded">
                                                            <i class="ki-outline ki-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $message->name }}</h6>
                                                    <p class="text-muted mb-0">{{ str($message->message)->limit(50) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ki-outline ki-messages fs-1 mb-2"></i>
                                                <p>@lang('dash.No messages found')</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Counter animation
        document.querySelectorAll('.counter-value').forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const increment = target / 100;
            
            const updateCounter = () => {
                const current = +counter.innerText;
                if (current < target) {
                    counter.innerText = Math.ceil(current + increment);
                    setTimeout(updateCounter, 20);
                } else {
                    counter.innerText = target;
                }
            };
            
            updateCounter();
        });
    </script>
    @endpush
</x-dashboard.layout>