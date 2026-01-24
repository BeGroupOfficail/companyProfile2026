<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#messageDetailsModal_{{ $row->id }}"
    data-id="{{ $row->id }}" title="@lang('dash.message')"
    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn_edit openMessageModal">
    <i class="ki-outline ki-messages fs-2"></i>
</a>
<div class="modal fade" id="messageDetailsModal_{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('dash.message')</h5>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal"
                    aria-label="@lang('dash.close')"></button>
            </div>
            <div class="modal-body">
                <div id="messageDetailsContent" class="p-3 text-center">
                    {{ $row->message ?? __('dash.no_message_available') }}
                </div>
                @if($row->user && $row->user->mainRequest)
                    <div class="mb-5">
                        <div class="d-flex flex-wrap py-5">
                            <div class="card-body pb-0">
                                <!--begin::Col-->
                                <div class="flex-equal me-5">
                                    <div class="mb-3">
                                        <h6 class="text-muted d-inline-block min-w-125px">@lang('dash.name'):</h6>
                                        <span class="text-gray-800">{{ $row->user->mainRequest->name }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="text-muted d-inline-block min-w-125px">@lang('dash.email'):</h6>
                                        <span class="text-gray-800">{{ $row->user->mainRequest->email }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="text-muted d-inline-block min-w-125px">@lang('dash.phone'):</h6>
                                        <span class="text-gray-800">{{ $row->user->mainRequest->phone }}</span>
                                    </div>
                                </div>
                                <div class="flex-equal me-5">
                                    <div class="mb-3">
                                        <h6 class="text-muted d-inline-block min-w-125px">@lang('dash.education_level'):</h6>
                                        <span class="text-gray-800">{{ $row->educationLevel?->name }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="text-muted d-inline-block min-w-125px">@lang('dash.job'):</h6>
                                        <span class="text-gray-800">{{ $row->user->mainRequest->job_title  }}</span>
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                    </div>
                @elseif($row->user && $row->user->companyMainRequest)
                <div class="mb-5">
                    <div class="d-flex flex-wrap py-5">
                        <div class="card-body pb-0">
                            <div class="flex-equal me-5">
                                <div class="mb-3">
                                    <h6 class="text-muted d-inline-block min-w-125px">@lang('dash.company_name'):</h6>
                                    <span class="text-gray-800">{{ $row->user->companyMainRequest->company_name }}</span>
                                </div>

                                <div class="mb-3">
                                    <h6 class="text-muted d-inline-block min-w-125px">@lang('dash.activity'):</h6>
                                    <span class="text-gray-800">{{$row->user->companyMainRequest->activity }}</span>
                                </div>

                                <div class="mb-3">
                                    <h6 class="text-muted d-inline-block min-w-125px">@lang('dash.responsible_name'):</h6>
                                    <span class="text-gray-800">{{ $row->user->companyMainRequest->responsible_name }}</span>
                                </div>

                                <div class="mb-3">
                                    <h6 class="text-muted d-inline-block min-w-125px">@lang('dash.responsible_email'):</h6>
                                    <span class="text-gray-800">{{  $row->user->companyMainRequest->responsible_email }}</span>
                                </div>

                                <div class="mb-3">
                                    <h6 class="text-muted d-inline-block min-w-125px">@lang('dash.responsible_phone'):</h6>
                                    <span class="text-gray-800">{{  $row->user->companyMainRequest->responsible_phone }}</span>
                                </div>

                                <div class="mb-3">
                                    <h6 class="text-muted d-inline-block min-w-125px">@lang('dash.message'):</h6>
                                    <span class="text-gray-800">{{  $row->user->companyMainRequest->message }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif
            </div>
        </div>
    </div>
</div>