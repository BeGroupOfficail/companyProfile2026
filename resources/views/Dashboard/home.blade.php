<x-dashboard.layout :title="__('dash.home page statistics')">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Row for Cards-->
            <div class="row g-6 g-xl-9">
               
                <!--begin::Super Admins Card-->
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card card-flush h-md-100 shadow-lg border-0 overflow-hidden" style="background: linear-gradient(135deg, #FFC107, #FF9800);">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <i class="ki-outline ki-abstract-26 fs-1 text-white me-3"></i>
                                <h3 class="card-title text-white fw-bold fs-4">{{ trans('dash.super_admins_count') }}</h3>
                            </div>
                            <span class="fs-2hx fw-bold text-white">{{ $superAdminsCount }}</span>
                            <div class="progress h-6px mt-5 bg-white bg-opacity-20">
                                <div class="progress-bar bg-white" role="progressbar" style="width: {{ ($superAdminsCount / ($superAdminsCount + 1)) * 100 }}%;" aria-valuenow="{{ $superAdminsCount }}" aria-valuemin="0" aria-valuemax="{{ $superAdminsCount + 1 }}"></div>
                            </div>
                            </div>
                    </div>
                </div>
                <!--end::Super Admins Card-->

            </div>
            <!--end::Row for Charts-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::Styles for Custom Tooltips-->
    <style>
        .chartjs-tooltip {
            opacity: 1;
            position: absolute;
            background: rgba(0, 0, 0, 0.9);
            color: white;
            border-radius: 8px;
            padding: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            pointer-events: none;
            transform: translate(-50%, 0);
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        .chartjs-tooltip-key {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-right: 5px;
            border-radius: 2px;
        }
    </style>
    <!--end::Styles for Custom Tooltips-->

    <!--begin::Chart.js and Particles.js Scripts-->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
        <script>
          

            // User Roles Chart (Bar with Gradient)
            const userRolesCtx = document.getElementById('userRolesChart').getContext('2d');
            const userRolesGradient1 = userRolesCtx.createLinearGradient(0, 0, 0, 300);
            userRolesGradient1.addColorStop(0, '#00A3FF');
            userRolesGradient1.addColorStop(1, '#007BFF');
            const userRolesGradient2 = userRolesCtx.createLinearGradient(0, 0, 0, 300);
            userRolesGradient2.addColorStop(0, '#50CD89');
            userRolesGradient2.addColorStop(1, '#28A745');
            const userRolesGradient3 = userRolesCtx.createLinearGradient(0, 0, 0, 300);
            userRolesGradient3.addColorStop(0, '#F1416C');
            userRolesGradient3.addColorStop(1, '#DC3545');
            new Chart(userRolesCtx, {
                type: 'bar',
                data: {
                    labels: [ "{{ trans('dash.students') }}", "{{ trans('dash.instructors') }}" , "{{ trans('dash.super_admins') }}" ],
                    datasets: [{
                        label: "{{ trans('dash.user_roles') }}",
                        data: [ {{ $superAdminsCount }}],
                        backgroundColor: [userRolesGradient1],
                        borderColor: ['#0095E8', '#45B774', '#D9345A'],
                        borderWidth: 1,
                        shadowOffsetX: 3,
                        shadowOffsetY: 3,
                        shadowBlur: 10,
                        shadowColor: 'rgba(0,0,0,0.3)'
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 2500,
                        easing: 'easeOutElastic'
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false },
                        customTooltip
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: "{{ trans('dash.count') }}",
                                font: { size: 14, family: 'Poppins', weight: 'bold' },
                                color: '#2B2D42'
                            },
                            grid: { color: 'rgba(0,0,0,0.1)' }
                        },
                        x: {
                            title: {
                                display: true,
                                text: "{{ trans('dash.roles') }}",
                                font: { size: 14, family: 'Poppins', weight: 'bold' },
                                color: '#2B2D42'
                            }
                        }
                    },
                    layout: {
                        padding: 20
                    }
                }
            });

     </script>
    @endpush
    <!--end::Chart.js and Particles.js Scripts-->
</x-dashboard.layout>