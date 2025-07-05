<x-dashboard.layout :title="__('dash.edit_settings')">

    <!--begin::Form-->
    <form method="POST" action="{{ route('settings.general-settings.update', $settings->id) }}"
          class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <!--begin:::Tabs-->
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-semibold mb-15"
                role="tablist">
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
                    <a class="nav-link d-flex align-items-center pb-5" data-bs-toggle="tab"
                       href="#tab01" aria-selected="true" role="tab">
                        <i class="ki-outline ki-photoshop fs-2 me-2"></i> @lang('dash.site_logos')
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                       href="#tab2" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-outline ki-sms fs-2 me-2"></i> @lang('dash.email_setting')
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                       href="#tab3" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-outline ki-social-media fs-2 me-2"></i> @lang('dash.social_media_links')
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                       href="#tab4" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-outline ki-google fs-2 me-2"></i> @lang('dash.google_captcha')
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                       href="#tab6" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-outline ki-chart-line-star  fs-2 me-2"></i> @lang('dash.analytics')
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                       href="#tab7" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-outline ki-text-number  fs-2 me-2"></i> @lang('dash.website_statistics')
                    </a>
                </li>
                <!--end:::Tab item-->

            </ul>
            <!--end:::Tabs-->

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
                                    @foreach (config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.textarea_with_editor name="site_desc_{{ $lang }}"
                                                                                        label="{{ __('dash.site_desc') }} ({{ __($languageName) }})"
                                                                                        :value="old(
                                                'site_desc' . $lang,
                                                $settings->getTranslation('site_desc', $lang) ?? '',
                                            )"
                                                                                        placeholder="{{ __('dash.Enter the short dec in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="contact_email" type="email"
                                                                     label="{{ __('dash.contact_email') }}" :value="old('contact_email', $settings->contact_email)"
                                                                     placeholder="{{ __('dash.contact_email') }}" />

                                    <x-dashboard.partials.html.input name="support_email" type="email"
                                                                     label="{{ __('dash.support_email') }}" :value="old('support_email', $settings->support_email)"
                                                                     placeholder="{{ __('dash.support_email') }}" />

                                    <x-dashboard.partials.html.input name="fax" label="{{ __('dash.fax') }}"
                                                                     :value="old('fax', $settings->fax)" placeholder="{{ __('dash.fax') }}" />

                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="telephone"
                                                                     label="{{ __('dash.telephone') }}" :value="old('telephone', $settings->telephone)"
                                                                     placeholder="{{ __('dash.telephone') }}" />

                                    <x-dashboard.partials.html.input name="phone1" label="{{ __('dash.phone1') }}"
                                                                     :value="old('phone1', $settings->phone1)" placeholder="{{ __('dash.phone1') }}" />

                                    <x-dashboard.partials.html.input name="phone2" label="{{ __('dash.phone2') }}"
                                                                     :value="old('phone2', $settings->phone2)" placeholder="{{ __('dash.phone2') }}" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="address1"
                                                                     label="{{ __('dash.address1') }}" :value="old('address1', $settings->address1)"
                                                                     placeholder="{{ __('dash.address1') }}" />

                                    <x-dashboard.partials.html.input name="address2"
                                                                     label="{{ __('dash.address2') }}" :value="old('address2', $settings->address2)"
                                                                     placeholder="{{ __('dash.address2') }}" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.textarea name="google_map"
                                                                        label="{{ __('dash.google_map') }}" :value="old('google_map', $settings->google_map ?? '')"
                                                                        placeholder="{{ __('dash.Enter google map url') }}" />
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
                <div class="tab-pane" id="tab3" role="tab-panel">
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
                                    <x-dashboard.partials.html.input name="nocaptcha_sitekey"
                                                                     label="{{ __('dash.nocaptcha_sitekey') }}" :value="old('nocaptcha_sitekey', $settings->nocaptcha_sitekey)"
                                                                     placeholder="{{ __('dash.nocaptcha_sitekey') }}" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="nocaptcha_secret"
                                                                     label="{{ __('dash.nocaptcha_secret') }}" :value="old('nocaptcha_secret', $settings->nocaptcha_secret)"
                                                                     placeholder="{{ __('dash.nocaptcha_secret') }}" />
                                </div>

                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane-->
                <div class="tab-pane" id="tab6" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::General options-->
                        <div class="card card-flush py-4">

                            <!--begin::Card body-->
                            <div class="card-body pt-0">

                                <div class="card-title">
                                    <hr class="low-opacity">
                                    <h5>{{ __('dash.google analytics') }} </h5>
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="google_tag_manager_id"
                                                                     label="{{ __('dash.google_tag_manager_id') }}" :value="old('google_tag_manager_id', $settings->google_tag_manager_id)"
                                                                     placeholder="{{ __('dash.google_tag_manager_id') }}" />

                                    <x-dashboard.partials.html.textarea name="google_tag_manager_for_body"
                                                                        label="{{ __('dash.google_tag_manager_for_body') }}" :value="old(
                                            'google_tag_manager_for_body',
                                            $settings->google_tag_manager_for_body,
                                        )"
                                                                        placeholder="{{ __('dash.google_tag_manager_for_body') }}" />

                                    <x-dashboard.partials.html.textarea name="google_tag_manager_for_head"
                                                                        label="{{ __('dash.google_tag_manager_for_head') }}" :value="old(
                                            'google_tag_manager_for_head',
                                            $settings->google_tag_manager_for_head,
                                        )"
                                                                        placeholder="{{ __('dash.google_tag_manager_for_head') }}" />
                                </div>


                                <div class="card-title">
                                    <hr class="low-opacity">
                                    <h5>{{ __('dash.facebook analytics') }} </h5>
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.textarea name="facebook_pixel_for_body"
                                                                        label="{{ __('dash.facebook_pixel_for_body') }}" :value="old('facebook_pixel_for_body', $settings->facebook_pixel_for_body)"
                                                                        placeholder="{{ __('dash.facebook_pixel_for_body') }}" />

                                    <x-dashboard.partials.html.textarea name="facebook_pixel_for_head"
                                                                        label="{{ __('dash.facebook_pixel_for_head') }}" :value="old('facebook_pixel_for_head', $settings->facebook_pixel_for_head)"
                                                                        placeholder="{{ __('dash.nocaptcha_secret') }}" />
                                </div>

                                <div class="card-title">
                                    <hr class="low-opacity">
                                    <h5>{{ __('dash.tiktok analytics') }} </h5>
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.textarea name="tiktok_pixel_for_body"
                                                                        label="{{ __('dash.tiktok_pixel_for_body') }}" :value="old('tiktok_pixel_for_body', $settings->tiktok_pixel_for_body)"
                                                                        placeholder="{{ __('dash.tiktok_pixel_for_body') }}" />

                                    <x-dashboard.partials.html.textarea name="tiktok_pixel_for_head"
                                                                        label="{{ __('dash.tiktok_pixel_for_head') }}" :value="old('tiktok_pixel_for_head', $settings->tiktok_pixel_for_head)"
                                                                        placeholder="{{ __('dash.tiktok_pixel_for_head') }}" />
                                </div>

                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane-->
                <div class="tab-pane" id="tab7" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::General options-->
                        <div class="card card-flush py-4">

                            <!--begin::Card body-->
                            <div class="card-body pt-0">

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input name="n_experience_years" type="number"
                                                                     label="{{ __('dash.n_experience_years') }}" :value="old('n_experience_years', $settings->n_experience_years)"
                                                                     placeholder="{{ __('dash.n_experience_years') }}" />

                                    <x-dashboard.partials.html.input name="n_awrds" type="number"
                                                                     label="{{ __('dash.n_awrds') }}" :value="old('n_awrds', $settings->n_awrds)"
                                                                     placeholder="{{ __('dash.n_awrds') }}" />

                                    <x-dashboard.partials.html.input name="n_tours" type="number"
                                                                     label="{{ __('dash.n_tours') }}" :value="old('n_tours', $settings->n_tours)"
                                                                     placeholder="{{ __('dash.n_tours') }}" />

                                    <x-dashboard.partials.html.input name="n_travelers" type="number"
                                                                     label="{{ __('dash.n_travelers') }}" :value="old('n_travelers', $settings->n_travelers)"
                                                                     placeholder="{{ __('dash.n_travelers') }}" />
                                </div>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->

                    </div>
                </div>

                <div class="tab-pane" id="tab01" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <div class="d-flex flex-wrap gap-5">
                            <!--begin::image-->
                            <x-dashboard.partials.html.image_input :title="'Upload Main Logo'" :name="'logo'" :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'"
                                                                   :changeImageText="'Change Logo'" :cancelImageText="'Cancel Logo'" :removeImageText="'Remove Logo'" :acceptedText="'image files are accepted'" :model="$settings"
                                                                   :imageModelName="'settings'" />
                            <!--end::image -->

                            <!--begin::image-->
                            <x-dashboard.partials.html.image_input :title="'Upload Dark Logo'" :name="'dark_logo'" :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'"
                                                                   :changeImageText="'Change Logo'" :cancelImageText="'Cancel Logo'" :removeImageText="'Remove Logo'" :acceptedText="'image files are accepted'" :model="$settings"
                                                                   :imageModelName="'settings'" />
                            <!--end::image -->

                            <!--begin::image-->
                            <x-dashboard.partials.html.image_input :title="'Upload white Logo'" :name="'white_logo'" :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'"
                                                                   :changeImageText="'Change Logo'" :cancelImageText="'Cancel Logo'" :removeImageText="'Remove Logo'" :acceptedText="'image files are accepted'" :model="$settings"
                                                                   :imageModelName="'settings'" />
                            <!--end::image -->

                            <!--begin::image-->
                            <x-dashboard.partials.html.image_input :title="'Upload Fav Icon'" :name="'fav_icon'" :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'"
                                                                   :changeImageText="'Change Fav Icon'" :cancelImageText="'Cancel Fav Icon'" :removeImageText="'Remove Fav Icon'" :acceptedText="'image files are accepted'" :model="$settings"
                                                                   :imageModelName="'settings'" />
                            <!--end::image -->
                        </div>

                    </div>
                </div>

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
    <!--end::Form-->

</x-dashboard.layout>
