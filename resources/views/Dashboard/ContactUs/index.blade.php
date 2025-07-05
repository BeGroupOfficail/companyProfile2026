<x-dashboard.layout :title="__('dash.contactUs')">

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xl-row p-7">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-xl-15 mb-20 mb-xl-0">
                    @if($messages->count() > 0)
                    <!--begin::Tickets-->
                    <div class="mb-0">
                        <!--begin::Tickets List-->
                        <div class="mb-10">
                            <table class="col-12">
                                @foreach ($messages as $message)
                                    <tr>
                                        <td>
                                            <!--begin::Ticket-->
                                            <div class="d-flex mb-10">
                                                <!--begin::Symbol-->
                                                <i
                                                    class="ki-outline ki-user fs-2x me-5 ms-n1 mt-2 text-{{ $message->seen ? "info" : "success" }}"></i>
                                                <!--end::Symbol-->

                                                <!--begin::Section-->
                                                <div class="col-12">
                                                    <!--begin::Content-->
                                                    <div class="d-flex align-items-center mb-2">
                                                        <!--begin::Title-->
                                                        <a
                                                            class="text-gray-900 text-hover-primary fs-4 me-3 fw-semibold">{{ $message->name }}</a>
                                                        <!--end::Title-->
                                                        <!--begin::Label-->
                                                        <span class="badge badge-light my-1">{{ $message->title }}</span>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Content-->

                                                    <!--begin::Text-->
                                                    <div class="row justify-content-between align-items-center">
                                                        <div class="col-8">
                                                            <span class="text-muted fw-semibold fs-6">{{ $message->message }}</span>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="card-toolbar">
                                                                @if (!$message->seen)
                                                                    <a class="btn btn-light-primary btn-sm p-2 "
                                                                        href="{{ route('contact-us.show', $message) }}">
                                                                        @lang('dash.mark_as_read')
                                                                    </a>
                                                                @endif
                                                                <a class="btn btn-light-danger btn-sm p-2 delete_me" data-delete_route="{{route('contact-us.destroy', $message->id)  }}"
                                                                    href="javascript:void()">
                                                                    @lang('dash.delete')
                                                                </a>
                                                            </div>
                                                            <span
                                                                class="text-muted fw-semibold fs-6">{{__('dash.phone') . ' | ' . $message->phone }}</span>
                                                            <span
                                                                class="text-muted fw-semibold fs-6">{{__('dash.email') . ' | ' . $message->email }}</span>
                                                        </div>
                                                    </div>
                                                    <!--end::Text-->
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                            <!--end::Ticket-->
                                            @if (!$loop->last)
                                                <hr>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <!--end::Tickets List-->
                        @if ($messages->lastPage() > 1)
                            <ul class="pagination">
                                {{-- Previous Page --}}
                                <li class="page-item {{ $messages->onFirstPage() ? 'disabled' : 'previous' }}">
                                    <a href="{{ $messages->previousPageUrl() ?? 'javascript:void(0);' }}"
                                        class="page-link "><i class="previous"></i></a>
                                </li>
                                {{-- Page Numbers --}}
                                @for ($i = 1; $i <= $messages->lastPage(); $i++)
                                    <li class="page-item {{ $messages->currentPage() == $i ? 'active' : '' }}">
                                        <a href="{{ $messages->url($i) }}" class="page-link">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Next Page --}}
                                <li class="page-item {{ $messages->hasMorePages() ? 'next' : 'disabled' }}">
                                    <a href="{{ $messages->nextPageUrl() ?? 'javascript:void(0);' }}" class="page-link"><i
                                            class="next"></i></a>
                                </li>

                            </ul>
                        @endif
                    </div>
                    <!--end::Tickets-->
                    @else
                        <div class="row g-5 gx-xl-10 mb-5 mb-xl-10 text-center">
                            <h4 class="text-muted">@lang("dash.no records added yet !!!")</h4>
                        </div>
                    @endif

                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

</x-dashboard.layout>
