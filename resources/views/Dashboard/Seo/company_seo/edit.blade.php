<x-dashboard.layout :title="__('dash.company_seo') ?? 'Company SEO'">
    <!--begin::Form-->
    <form method="POST" action="{{ route('company-seo.update') }}"
        class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2 ml--0">
                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5 active" data-bs-toggle="tab"
                        href="#tab_meta" aria-selected="true" role="tab">
                        <i class="ki-outline ki-document fs-2 me-2"></i> {{ __('dash.meta_tags') ?? 'Meta Tags' }}
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link d-flex align-items-center pb-5" data-bs-toggle="tab" href="#tab_og"
                        aria-selected="false" role="tab">
                        <i class="ki-outline ki-facebook fs-2 me-2"></i> {{ __('dash.open_graph') ?? 'Open Graph' }}
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                        href="#tab_twitter" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-outline ki-twitter fs-2 me-2"></i> {{ __('dash.twitter_card') ?? 'Twitter Card' }}
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                        href="#tab_hreflang" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-outline ki-translation fs-2 me-2"></i> {{ __('dash.hreflang') ?? 'Hreflang' }}
                    </a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                        href="#tab_schema" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-outline ki-code fs-2 me-2"></i> {{ __('dash.schema') ?? 'Schema' }}
                    </a>
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->

            <!--begin::Tab content-->
            <div class="tab-content ml--0">

                <!--begin::Tab pane (Meta)-->
                <div class="tab-pane fade show active" id="tab_meta" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-body pt-0">
                                <div class="d-flex flex-wrap gap-5 mt-5">
                                    <x-dashboard.partials.html.input name="content_type"
                                        label="{{ __('dash.content_type') ?? 'Content Type' }}"
                                        :value="old('content_type', $companySeo->content_type)"
                                        placeholder="text/html" />

                                    <x-dashboard.partials.html.input name="robots"
                                        label="{{ __('dash.robots') ?? 'Robots' }}"
                                        :value="old('robots', $companySeo->robots)"
                                        placeholder="index,follow" />
                                </div>

                                <div class="d-flex flex-wrap gap-5 mt-5">
                                    @foreach (config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input name="title_{{ $lang }}"
                                            label="{{ __('dash.title') ?? 'Title' }} ({{ __($languageName) }})"
                                            :value="old('title_' . $lang, $companySeo->getTranslation('title', $lang))"
                                            placeholder="{{ __('dash.title') ?? 'Title' }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap gap-5 mt-5">
                                    @foreach (config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input name="author_{{ $lang }}"
                                            label="{{ __('dash.author') ?? 'Author' }} ({{ __($languageName) }})"
                                            :value="old('author_' . $lang, $companySeo->getTranslation('author', $lang))"
                                            placeholder="{{ __('dash.author') ?? 'Author' }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>
                                
                                <div class="d-flex flex-wrap gap-5 mt-5">
                                    @foreach (config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input name="canonical_{{ $lang }}"
                                            label="{{ __('dash.canonical') ?? 'Canonical' }} ({{ __($languageName) }})"
                                            :value="old('canonical_' . $lang, $companySeo->getTranslation('canonical', $lang))"
                                            placeholder="https://schema.org" />
                                    @endforeach
                                </div>

                                <div class="mt-5">
                                    @foreach (config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.textarea name="description_{{ $lang }}"
                                            label="{{ __('dash.description') ?? 'Description' }} ({{ __($languageName) }})"
                                            :value="old('description_' . $lang, $companySeo->getTranslation('description', $lang))"
                                            placeholder="{{ __('dash.description') ?? 'Description' }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Tab pane (Meta)-->

                <!--begin::Tab pane (OG)-->
                <div class="tab-pane fade" id="tab_og" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-body pt-0">
                                @php
                                    $og = $companySeo->open_graph ?? [];
                                @endphp
                                <div class="d-flex flex-wrap gap-5 mt-5">
                                    <x-dashboard.partials.html.input name="open_graph[og:title]"
                                        label="OG Title"
                                        :value="old('open_graph.og:title', $og['og:title'] ?? '')"
                                        placeholder="OG Title" />

                                    <x-dashboard.partials.html.input name="open_graph[og:type]"
                                        label="OG Type"
                                        :value="old('open_graph.og:type', $og['og:type'] ?? 'website')"
                                        placeholder="website" />
                                </div>

                                <div class="d-flex flex-wrap gap-5 mt-5">
                                    <x-dashboard.partials.html.input name="open_graph[og:url]"
                                        label="OG URL"
                                        :value="old('open_graph.og:url', $og['og:url'] ?? '')"
                                        placeholder="https://example.com" />

                                    <x-dashboard.partials.html.input name="open_graph[og:image]"
                                        label="OG Image"
                                        :value="old('open_graph.og:image', $og['og:image'] ?? '')"
                                        placeholder="Image URL" />
                                </div>

                                <div class="mt-5 w-100">
                                    <x-dashboard.partials.html.textarea name="open_graph[og:description]"
                                        label="OG Description"
                                        :value="old('open_graph.og:description', $og['og:description'] ?? '')"
                                        placeholder="OG Description" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane (Twitter)-->
                <div class="tab-pane fade" id="tab_twitter" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-body pt-0">
                                @php
                                    $twitter = $companySeo->twitter_card ?? [];
                                @endphp
                                <div class="d-flex flex-wrap gap-5 mt-5">
                                    <x-dashboard.partials.html.input name="twitter_card[twitter:card]"
                                        label="Twitter Card"
                                        :value="old('twitter_card.twitter:card', $twitter['twitter:card'] ?? 'summary_large_image')"
                                        placeholder="summary_large_image" />

                                    <x-dashboard.partials.html.input name="twitter_card[twitter:title]"
                                        label="Twitter Title"
                                        :value="old('twitter_card.twitter:title', $twitter['twitter:title'] ?? '')"
                                        placeholder="Twitter Title" />
                                </div>

                                <div class="d-flex flex-wrap gap-5 mt-5">
                                    <x-dashboard.partials.html.input name="twitter_card[twitter:image]"
                                        label="Twitter Image"
                                        :value="old('twitter_card.twitter:image', $twitter['twitter:image'] ?? '')"
                                        placeholder="Image URL" />
                                </div>

                                <div class="mt-5 w-100">
                                    <x-dashboard.partials.html.textarea name="twitter_card[twitter:description]"
                                        label="Twitter Description"
                                        :value="old('twitter_card.twitter:description', $twitter['twitter:description'] ?? '')"
                                        placeholder="Twitter Description" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane (Hreflang)-->
                <div class="tab-pane fade" id="tab_hreflang" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-body pt-0" id="hreflang_container">
                                @php
                                    $hreflangs = $companySeo->hreflang_tags ?? [];
                                @endphp
                                
                                <div class="d-flex justify-content-between align-items-center mb-5 mt-5">
                                    <h4>Hreflang Tags</h4>
                                    <button type="button" class="btn btn-sm btn-light-primary" id="add_hreflang">
                                        <i class="ki-outline ki-plus fs-2"></i> Add Tag
                                    </button>
                                </div>

                                @if(!empty($hreflangs))
                                    @foreach($hreflangs as $key => $val)
                                    <div class="d-flex gap-3 mb-3 hreflang-row">
                                        <input type="text" class="form-control" name="hreflang_keys[]" value="{{ $key }}" placeholder="Language Code (e.g., en, ar, x-default)" />
                                        <input type="text" class="form-control" name="hreflang_values[]" value="{{ $val }}" placeholder="URL Path (e.g., /en, /ar, /)" />
                                        <button type="button" class="btn btn-icon btn-light-danger remove-hreflang"><i class="ki-outline ki-trash"></i></button>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="d-flex gap-3 mb-3 hreflang-row">
                                        <input type="text" class="form-control" name="hreflang_keys[]" value="en" placeholder="Language Code (e.g., en, ar, x-default)" />
                                        <input type="text" class="form-control" name="hreflang_values[]" value="/en" placeholder="URL Path (e.g., /en, /ar, /)" />
                                        <button type="button" class="btn btn-icon btn-light-danger remove-hreflang"><i class="ki-outline ki-trash"></i></button>
                                    </div>
                                    <div class="d-flex gap-3 mb-3 hreflang-row">
                                        <input type="text" class="form-control" name="hreflang_keys[]" value="ar" placeholder="Language Code (e.g., en, ar, x-default)" />
                                        <input type="text" class="form-control" name="hreflang_values[]" value="/ar" placeholder="URL Path (e.g., /en, /ar, /)" />
                                        <button type="button" class="btn btn-icon btn-light-danger remove-hreflang"><i class="ki-outline ki-trash"></i></button>
                                    </div>
                                    <div class="d-flex gap-3 mb-3 hreflang-row">
                                        <input type="text" class="form-control" name="hreflang_keys[]" value="x-default" placeholder="Language Code (e.g., en, ar, x-default)" />
                                        <input type="text" class="form-control" name="hreflang_values[]" value="/" placeholder="URL Path (e.g., /en, /ar, /)" />
                                        <button type="button" class="btn btn-icon btn-light-danger remove-hreflang"><i class="ki-outline ki-trash"></i></button>
                                    </div>
                                @endif
                                
                                <!-- Template -->
                                <template id="hreflang_template">
                                    <div class="d-flex gap-3 mb-3 hreflang-row">
                                        <input type="text" class="form-control" name="hreflang_keys[]" value="" placeholder="Language Code (e.g., en, ar, x-default)" />
                                        <input type="text" class="form-control" name="hreflang_values[]" value="" placeholder="URL Path (e.g., /en, /ar, /)" />
                                        <button type="button" class="btn btn-icon btn-light-danger remove-hreflang"><i class="ki-outline ki-trash"></i></button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane (Schema)-->
                <div class="tab-pane fade" id="tab_schema" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-body pt-0">
                                @php
                                    $schemaValue = $companySeo->schema ? json_encode($companySeo->schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : "[\n  {\n    \"@context\": \"https://schema.org\",\n    \"@type\": \"WebPage\"\n  }\n]";
                                @endphp
                                <div class="mt-5 w-100">
                                    <label class="form-label">{{ __('dash.schema') ?? 'Schema JSON' }}</label>
                                    <textarea name="schema" class="form-control form-control-solid" rows="15" placeholder="Enter valid JSON schema here">{{ old('schema', $schemaValue) }}</textarea>
                                </div>
                            </div>
                        </div>
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('hreflang_container');
            const addButton = document.getElementById('add_hreflang');
            const template = document.getElementById('hreflang_template');

            addButton.addEventListener('click', function() {
                const clone = template.content.cloneNode(true);
                container.appendChild(clone);
            });

            container.addEventListener('click', function(e) {
                if (e.target.closest('.remove-hreflang')) {
                    e.target.closest('.hreflang-row').remove();
                }
            });
        });
    </script>
    @endpush
</x-dashboard.layout>
