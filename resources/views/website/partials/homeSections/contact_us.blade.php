<section class="contact-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7">
                <div class="contact-page__left">
                    <h3 class="contact-page__title">@lang('home.Contact With us')</h3>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="contact-form-validated contact-page__form" action="{{ route('website.contact-us-save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="contact-page__input-box">
                                    <input type="text" name="name" placeholder="@lang('home.name')" value="{{ old('name') }}" required/>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="contact-page__input-box">
                                    <input type="email" name="email" placeholder="@lang('home.email')" value="{{ old('email') }}" required/>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="contact-page__input-box">
                                    <input type="text" name="phone" placeholder="@lang('home.phone')" value="{{ old('phone') }}" required/>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="contact-page__input-box text-message-box">
                                    <textarea name="message" placeholder="@lang('home.message')" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="contact-page__btn-box">
                                    <button type="submit" class="thm-btn">
                                        @lang('home.Submit')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5">
                <div class="contact-page__right">
                    <div class="section-title text-left sec-title-animation animation-style2">
                        <h6 class="section-title__tagline">
                            <span class="icon-broken-bone"></span>@lang('home.Get In Touch')
                        </h6>
                        <h3 class="section-title__title title-animation">
                            @lang('home.Climate Control Excellence')
                        </h3>
                    </div>
                    <p class="contact-page__text">
                        @lang('home.contact_description')
                    </p>
                    <ul class="contact-page__contact-list list-unstyled">
                        <li>
                            <div class="icon">
                                <span class="icon-call"></span>
                            </div>
                            <div class="content">
                                <h3>@lang('home.Phone')</h3>
                                <p><a href="tel:{{ $settings->phone1}}">{{ $settings->phone1}}</a></p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <span class="icon-envolope"></span>
                            </div>
                            <div class="content">
                                <h3>@lang('home.Email')</h3>
                                <p><a href="mailto:{{ $settings->contact_email}}">{{ $settings->contact_email}}</a></p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <span class="icon-pin"></span>
                            </div>
                            <div class="content">
                                <h3>@lang('home.Location')</h3>
                                <p>{{ app()->getLocale() == 'en' ? $settings->address_en_1 : $settings->address1 }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
