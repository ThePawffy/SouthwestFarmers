<section class="pricing-plan-section plans-list" id="plans">
    <div class="container">
        <div class="section-title text-center">
            <p data-aos="fade-up" class="langing-section-subtitle">
                {{ Str::words($page_data['headings']['pricing_short_title'] ?? '', 15, '...') }}</p>
            <h2 data-aos="fade-up" class="langing-section-title pb-4 ">
                {{ Str::words($page_data['headings']['pricing_title'] ?? '', 15, '...') }}</h2>

            <div class="d-flex align-items-center justify-content-center gap-4">

                <div class="w-100 d-flex flex-column align-items-center">
                    <div class="tab-content w-100" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-monthly" role="tabpanel"
                            aria-labelledby="nav-monthly-tab">
                            <div class="row">
                                @foreach ($plans as $plan)
                                    <div class="col-sm-6 col-md-4 col-lg-4 mt-3">
                                        <div class="card">
                                            <div class="card-header py-3 border-0">
                                                <p>{{ $plan->subscriptionName }}</p>
                                                <h4>{{ currency_format($plan->offerPrice ?? ($plan->subscriptionPrice ?? 0)) }}
                                                    <span class="price-span">/
                                                        {{ $plan->duration . ' ' . __('Days') }}</span></h4>
                                            </div>
                                            <div
                                                class="card-body text-start mt-3 d-flex flex-column justify-content-between h-100">
                                                <ul class="features-list d-flex align-items-start flex-column gap-1">
                                                    @foreach ($plan['features'] ?? [] as $key => $item)
                                                        {{-- <li class="feature-item">
                                                            <img src="{{ asset('modules/landing/web/images/banner/plan-check.svg') }}"
                                                            alt="Check" class="me-1 plan-icon">
                                                            <span class="single-features">{{ $item[0] ?? '' }}</span>
                                                        </li> --}}

                                                        <li class="d-flex align-items-center gap-2">
                                                            @if (isset($item[1]))
                                                                <svg width="15" height="11" viewBox="0 0 15 11"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg"
                                                                    class="me-1">
                                                                    <path
                                                                        d="M5.20009 10.4298C4.9542 10.4298 4.7088 10.3375 4.52102 10.1524L0 5.69601L1.35813 4.35683L5.20009 8.14383L12.884 0.569824L14.2421 1.909L5.87915 10.1524C5.69138 10.3375 5.44597 10.4298 5.20009 10.4298Z"
                                                                        fill="#01AA2E" />
                                                                </svg>
                                                            @else
                                                                <svg width="12" height="12" viewBox="0 0 12 12"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M11.0533 1.01221L1 11.0655L11.0533 1.01221Z"
                                                                        fill="#01AA2E" />
                                                                    <path d="M11.0533 1.01221L1 11.0655"
                                                                        stroke="#FF0505" stroke-width="1.67554"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M11.0533 11.0655L1 1.01221L11.0533 11.0655Z"
                                                                        fill="#01AA2E" />
                                                                    <path d="M11.0533 11.0655L1 1.01221"
                                                                        stroke="#FF0505" stroke-width="1.67554"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                </svg>
                                                            @endif
                                                            {{ $item[0] ?? '' }}
                                                        </li>
                                                    @endforeach
                                                </ul>

                                                @if (count($plan['features'] ?? []) > 8)
                                                    <button
                                                        class="btn text-start p-0 see-more-btn">{{ __('See More') }}</button>
                                                @endif

                                                <a class="btn subscribe-plan d-block mt-4 mb-2"
                                                    data-bs-target="#registration-modal"
                                                    data-bs-toggle="modal">{{ __('Buy Now') }}</a>


                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@include('landing::web.components.signup')
