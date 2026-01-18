<x-dashboard.layout :title="__('dash.edit_settings')">
    <!--begin::Form-->
    <form method="POST" action="{{ route('settings.general-settings.update', $settings->id) }}"
        class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data" onsubmit="prepareFields()">
        @csrf
        @method('PATCH')

        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2 ml--0">

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5 active" data-bs-toggle="tab"
                        href="#tab1" aria-selected="true" role="tab">
                        <i class="ki-outline ki-home fs-2 me-2"></i> @lang('dash.site_setting')
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link d-flex align-items-center pb-5" data-bs-toggle="tab" href="#tab2"
                        aria-selected="true" role="tab">
                        <i class="ki-outline ki-photoshop fs-2 me-2"></i> @lang('dash.site_logos')
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                        href="#tab3" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-outline ki-sms fs-2 me-2"></i> @lang('dash.email_setting')
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                        href="#tab4" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-outline ki-sms fs-2 me-2"></i> @lang('dash.sms_setting')
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                        href="#tab5" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-outline ki-social-media fs-2 me-2"></i> @lang('dash.social_media_links')
                    </a>
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->

            <!--begin::Tab content-->
            <div class="tab-content ml--0">

                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" id="tab1" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="d-flex flex-wrap gap-5">
                                    @foreach (config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input name="site_name_{{ $lang }}"
                                            label="{{ __('dash.site_name') }} ({{ __($languageName) }})"
                                            :value="old(
                                                'site_name_' . $lang,
                                                $settings->getTranslation('site_name', $lang) ?? '',
                                            )"
                                            placeholder="{{ __('dash.Enter the name in') }} {{ __($languageName) }}" />
                                    @endforeach

                                    <x-dashboard.partials.html.input name="primary_color" type="color"
                                        label="{{ __('dash.primary_color') }}" :value="old('primary_color', $settings->primary_color)"
                                        placeholder="{{ __('dash.primary_color') }}" />

                                    <x-dashboard.partials.html.input name="secondary_color" type="color"
                                        label="{{ __('dash.secondary_color') }}" :value="old('secondary_color', $settings->secondary_color)"
                                        placeholder="{{ __('dash.secondary_color') }}" />

                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="contact_email" type="email"
                                        label="{{ __('dash.contact_email') }}" :value="old('contact_email', $settings->contact_email)"
                                        placeholder="{{ __('dash.contact_email') }}" />

                                    <x-dashboard.partials.html.input name="support_email" type="email"
                                        label="{{ __('dash.support_email') }}" :value="old('support_email', $settings->support_email)"
                                        placeholder="{{ __('dash.support_email') }}" />

                                    <x-dashboard.partials.html.input name="fax" label="{{ __('dash.fax') }}" type="number"
                                        :value="old('fax', $settings->fax)" placeholder="{{ __('dash.fax') }}" />

                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="telephone" type="number"
                                        label="{{ __('dash.telephone') }}" :value="old('telephone', $settings->telephone)"
                                        placeholder="{{ __('dash.telephone') }}" />

                                    <x-dashboard.partials.html.input name="phone1" label="{{ __('dash.phone1') }}" type="number"
                                        :value="old('phone1', $settings->phone1)" placeholder="{{ __('dash.phone1') }}" />
                                </div>


                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="postal_code" type="number"
                                                                     label="{{ __('dash.postal_code') }}" :value="old('postal_code', $settings->postal_code)"
                                                                     placeholder="{{ __('dash.postal_code') }}" />
                                    <x-dashboard.partials.html.input name="address1"
                                                                     label="{{ __('dash.address1') }}" :value="old('address1', $settings->address1)"
                                                                     placeholder="{{ __('dash.address1') }}" />

                                    <x-dashboard.partials.html.input name="address2"
                                                                     label="{{ __('dash.address2') }}" :value="old('address2', $settings->address2)"
                                                                     placeholder="{{ __('dash.address2') }}" />

                                    <x-dashboard.partials.html.input name="address_en_1"
                                        label=" {{ __('home.en') . ' ' . __('dash.address1') }}" :value="old('address_en_1', $settings->address_en_1)"
                                        placeholder=" {{ __('home.en') . ' ' . __('dash.address1') }}" />


                                    <x-dashboard.partials.html.input name="address_en_2"
                                        label=" {{ __('home.en') . ' ' . __('dash.address2') }}" :value="old('address_en_2', $settings->address_en_2)"
                                        placeholder=" {{ __('home.en') . ' ' . __('dash.address2') }}" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.textarea name="google_map"
                                        label="{{ __('dash.google_map') }}" :value="old('google_map', $settings->google_map ?? '')"
                                        placeholder="{{ __('dash.Enter google map url') }}" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach (config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.textarea_with_editor :name="'site_desc_' . $lang"
                                                                                        :label="__('dash.site_desc') . '(' . $languageName . ')'" :value="old(
                                                'site_desc' . $lang,
                                                $settings->getTranslation('site_desc', $lang) ?? '',
                                            )" :placeholder="__('dash.Enter the short dec in') . $languageName" />
                                    @endforeach
                                </div>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane-->
                <div class="tab-pane" id="tab2" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <div class="d-flex flex-wrap gap-7">
                            <!--begin::image-->
                            <x-dashboard.partials.html.image_input :title="'Upload Main Logo'" :name="'logo'"
                                :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'" :changeImageText="'Change Logo'" :cancelImageText="'Cancel Logo'" :removeImageText="'Remove Logo'"
                                :acceptedText="'image files are accepted'" :model="$settings" :imageModelName="'settings'" />
                            <!--end::image -->

                            <!--begin::image-->
                            <x-dashboard.partials.html.image_input :title="'Upload Dark Logo'" :name="'dark_logo'"
                                :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'" :changeImageText="'Change Logo'" :cancelImageText="'Cancel Logo'" :removeImageText="'Remove Logo'"
                                :acceptedText="'image files are accepted'" :model="$settings" :imageModelName="'settings'" />
                            <!--end::image -->

                            <!--begin::image-->
                            <x-dashboard.partials.html.image_input :title="'Upload white Logo'" :name="'white_logo'"
                                :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'" :changeImageText="'Change Logo'" :cancelImageText="'Cancel Logo'" :removeImageText="'Remove Logo'"
                                :acceptedText="'image files are accepted'" :model="$settings" :imageModelName="'settings'" />
                            <!--end::image -->

                            <!--begin::image-->
                            <x-dashboard.partials.html.image_input :title="'Upload Fav Icon'" :name="'fav_icon'"
                                :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'" :changeImageText="'Change Fav Icon'" :cancelImageText="'Cancel Fav Icon'" :removeImageText="'Remove Fav Icon'"
                                :acceptedText="'image files are accepted'" :model="$settings" :imageModelName="'settings'" />
                            <!--end::image -->
                        </div>

                    </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane-->
                <div class="tab-pane" id="tab3" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::General options-->
                        <div class="card card-flush py-4">

                            <!--begin::Card body-->
                            <div class="card-body pt-0">

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="mail_host" label="Mail Host"
                                        :value="old('mail_host', $settings->mail_host)" placeholder="Mail Host" />

                                    <x-dashboard.partials.html.input name="mail_port" label="Mail Port"
                                        :value="old('mail_port', $settings->mail_port)" placeholder="Mail Port" />

                                    <x-dashboard.partials.html.input name="mail_encryption" label="Mail Encryption"
                                        :value="old('mail_encryption', $settings->mail_encryption)" placeholder="Mail Encryption" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="mail_from_address" type="email"
                                        label="Mail From Address" :value="old('mail_from_address', $settings->mail_from_address)"
                                        placeholder="Mail From Address" />

                                    <x-dashboard.partials.html.input name="mail_from_name" label="Mail From Name"
                                        :value="old('mail_from_name', $settings->mail_from_name)" placeholder="Mail From Name" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">

                                    <x-dashboard.partials.html.input name="mail_username" label="Mail User Name"
                                        :value="old('mail_username', $settings->mail_username)" placeholder="Mail User Name" />

                                    <x-dashboard.partials.html.input name="mail_password" label="Mail Password"
                                        :value="old('mail_password', $settings->mail_password)" placeholder="Mail Password" />
                                </div>

                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane-->
                <div class="tab-pane" id="tab4" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::General options-->
                        <div class="card card-flush py-4">

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="d-flex flex-wrap gap-5">
                                    <div class="col-md-6">
                                        <label class="form-label  text-nowrap"
                                            for="pop_type">{{ __('dash.type') }}</label>
                                        <select class="form-select mb-2" data-control="select2"
                                            data-hide-search="true" data-placeholder="Select an option"
                                            name="sms_provider">
                                            <option  disabled > {{ __('dash.select_provider') }}</option>
                                            @foreach ($sms_providers as $sms_provider)
                                                <option value="{{ $sms_provider }}" @selected($settings->sms_provider == $sms_provider)>
                                                    {{ __('dash.'.$sms_provider) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <x-dashboard.partials.html.input name="sms_sender_name" label="Sender Name"
                                        :value="old('sms_sender_name', $settings->sms_sender_name)" placeholder="Sender Name" />
                                    <x-dashboard.partials.html.input name="sms_user_name" label="sms user name"
                                        :value="old('sms_user_name', $settings->sms_user_name)" placeholder="Sms user name" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="sms_app_id" label="App Id"
                                        :value="old('sms_app_id', $settings->sms_app_id)" placeholder="App Id" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">

                                    <x-dashboard.partials.html.input name="sms_app_sec" label="App Secret"
                                        :value="old('sms_app_sec', $settings->sms_app_sec)" placeholder="App Secret" />

                                </div>

                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane-->
                <div class="tab-pane" id="tab5" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::General options-->
                        <div class="card card-flush py-4">

                            <!--begin::Card body-->
                            <div class="card-body pt-0">

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="facebook_address"
                                        label="{{ __('dash.facebook_address') }}" :value="old('facebook_address', $settings->facebook_address)"
                                        placeholder="{{ __('dash.facebook_address') }}" />

                                    <x-dashboard.partials.html.input name="twitter_address"
                                        label="{{ __('dash.twitter_address') }}" :value="old('email', $settings->twitter_address)"
                                        placeholder="{{ __('dash.twitter_address') }}" />

                                    <x-dashboard.partials.html.input name="threads_address"
                                        label="{{ __('dash.threads_address') }}" :value="old('threads_address', $settings->threads_address)"
                                        placeholder="{{ __('dash.threads_address') }}" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="youtube_address"
                                        label="{{ __('dash.youtube_address') }}" :value="old('youtube_address', $settings->youtube_address)"
                                        placeholder="{{ __('dash.youtube_address') }}" />

                                    <x-dashboard.partials.html.input name="instagram_address"
                                        label="{{ __('dash.instagram_address') }}" :value="old('instagram_address', $settings->instagram_address)"
                                        placeholder="{{ __('dash.instagram_address') }}" />

                                    <x-dashboard.partials.html.input name="pinterest_address"
                                        label="{{ __('dash.pinterest_address') }}" :value="old('pinterest_address', $settings->pinterest_address)"
                                        placeholder="{{ __('dash.pinterest_address') }}" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="linkedin_address"
                                        label="{{ __('dash.linkedin_address') }}" :value="old('linkedin_address', $settings->linkedin_address)"
                                        placeholder="{{ __('dash.linkedin_address') }}" />

                                    <x-dashboard.partials.html.input name="tumblr_address"
                                        label="{{ __('dash.tumblr_address') }}" :value="old('tumblr_address', $settings->tumblr_address)"
                                        placeholder="{{ __('dash.tumblr_address') }}" />

                                    <x-dashboard.partials.html.input name="flickr_address"
                                        label="{{ __('dash.flickr_address') }}" :value="old('flickr_address', $settings->flickr_address)"
                                        placeholder="{{ __('dash.flickr_address') }}" />
                                </div>
                                <div class="d-flex flex-wrap gap-5">

                                    <x-dashboard.partials.html.input name="snapchat_address"
                                        label="{{ __('dash.snapchat_address') }}" :value="old('snapchat_address', $settings->snapchat_address)"
                                        placeholder="{{ __('dash.snapchat_address') }}" />
                                    <x-dashboard.partials.html.input name="tiktok_address"
                                        label="{{ __('dash.tiktok_address') }}" :value="old('tiktok_address', $settings->tiktok_address)"
                                        placeholder="{{ __('dash.tiktok_address') }}" />
                                    <x-dashboard.partials.html.input name="whatsapp_address"
                                        label="{{ __('dash.whatsapp_address') }}" :value="old('whatsapp_address', $settings->whatsapp_address)"
                                        placeholder="{{ __('dash.whatsapp_address') }}" />
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
                <a href="{{ route('dashboard.home') }}" id="kt_ecommerce_add_product_cancel"
                    class="btn btn-light me-5">{{ __('dash.Cancel') }}</a>
                <!--end::Button-->

                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                    <span class="indicator-label">{{ __('dash.Save Changes') }}</span>
                    <span class="indicator-progress">{{ __('dash.Please wait...') }} <span
                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->

    </form>

</x-dashboard.layout>
