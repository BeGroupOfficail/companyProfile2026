<x-dashboard.layout :title="__('dash.messages') . ' | ' . __('dash.add')">

    <!--begin::Form-->
    <form method="post" action="{{ route('messages.send') }}" class="form d-flex flex-column flex-lg-row">
        @csrf


        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" id="tab1" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::General options-->
                        <div class="card card-flush py-4">

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.select :options="$types" :required="'required'"
                                    :selectedArray="old('type')" :name="'type'" :title="__('dash.message_type')" :id="'message_type_select'" />
                                    <x-dashboard.partials.html.select :options="$trainings" :required="'required'"
                                    :selectedArray="old('training_id')" :name="'training_id'" :title="__('dash.trainings')" :id="'training_select'" />
                                    <x-dashboard.partials.html.input name="subject" :required="'required'" label="{{ __('dash.subject') }}"
                                    :value="old('subject', '')" placeholder="{{ __('dash.subject') }}" />
                                </div>
                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.textarea name="message" :required="'required'" label="{{ __('dash.message') }}"
                                    :value="old('message', '')" placeholder="{{ __('dash.message') }}" />
                                </div>
                            </div>
                            <!--end::Card header-->

                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->

            </div>
            <!--end::Tab content-->

            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="{{ route('messages.index') }}" id="kt_ecommerce_add_product_cancel"
                    class="btn btn-light me-5">{{ __('dash.Cancel') }}</a>
                <!--end::Button-->

                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                    <span class="indicator-label">{{ __('dash.send') }}</span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
    <!--end::Form-->

</x-dashboard.layout>
