 @php
    $notStaff = auth()->user()->role != 'staff';
 @endphp

 <header class="main-header-section sticky-top">
     <div class="header-wrapper">
         <div class="header-left">
            <div class="header-logo">
                <a href="{{ route('business.dashboard.index') }}">
                    <img src="{{ asset(get_option('general')['business_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo">
                </a>
            </div>
             <div class="sidebar-opner menu-opener left-menu-opener"><i class="fal fa-bars" aria-hidden="true"></i></div>

             <div class="d-flex align-items-center gap-3 justify-content-center header-buttons">

                @if ($notStaff || visible_permission('salesListPermission'))
                 <a href="{{ route('business.sales.create') }}" class="pos-btn">
                     <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                         <path d="M2 6.66675H14" stroke="white" stroke-width="1.25" stroke-linejoin="round" />
                         <path d="M10 4H11.3333" stroke="white" stroke-width="1.25" stroke-linecap="round"
                             stroke-linejoin="round" />
                         <path
                             d="M14 8.66658V7.33325C14 4.50483 14 3.09061 13.1213 2.21193C12.2427 1.33325 10.8284 1.33325 8 1.33325C5.17157 1.33325 3.75736 1.33325 2.87868 2.21193C2 3.09061 2 4.50483 2 7.33325V8.66658C2 11.495 2 12.9093 2.87868 13.7879C3.75736 14.6666 5.17157 14.6666 8 14.6666C10.8284 14.6666 12.2427 14.6666 13.1213 13.7879C14 12.9093 14 11.495 14 8.66658Z"
                             stroke="white" stroke-width="1.25" />
                         <path d="M4.66666 9.33325H5.01754M7.82453 9.33325H8.17546M10.9825 9.33325H11.3333"
                             stroke="white" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                         <path d="M4.66666 12H5.01754M7.82453 12H8.17546M10.9825 12H11.3333" stroke="white"
                             stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                     </svg>

                     {{ __('Pos') }} </a>
                @endif

                @if ($notStaff || visible_permission('dueListPermission'))
                 <a href="{{ route('business.dues.index') }}" class="deu-list-btn">
                     <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                         <g clip-path="url(#clip0_3182_19693)">
                             <path
                                 d="M9.987 4.677C9.987 4.677 10.3203 5.01034 10.6537 5.677C10.6537 5.677 11.7125 4.01034 12.6537 3.677"
                                 stroke="white" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                             <path
                                 d="M6.66327 1.3476C4.99763 1.27708 3.71079 1.46896 3.71079 1.46896C2.89822 1.52706 1.34101 1.98261 1.34103 4.64307C1.34104 7.28091 1.3238 10.5329 1.34103 11.8293C1.34103 12.6214 1.83144 14.4689 3.52888 14.5679C5.59211 14.6883 9.30853 14.7139 11.0137 14.5679C11.4701 14.5422 12.9898 14.1838 13.1821 12.5304C13.3814 10.8176 13.3417 9.62718 13.3417 9.34384"
                                 stroke="white" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                             <path
                                 d="M14.6666 4.67708C14.6666 6.51803 13.1728 8.01044 11.3301 8.01044C9.48733 8.01044 7.99353 6.51803 7.99353 4.67708C7.99353 2.83614 9.48733 1.34375 11.3301 1.34375C13.1728 1.34375 14.6666 2.83614 14.6666 4.67708Z"
                                 stroke="white" stroke-width="1.25" stroke-linecap="round" />
                             <path d="M4.65369 8.677H7.32033" stroke="white" stroke-width="1.25"
                                 stroke-linecap="round" />
                             <path d="M4.65369 11.3438H9.987" stroke="white" stroke-width="1.25"
                                 stroke-linecap="round" />
                         </g>
                         <defs>
                             <clipPath id="clip0_3182_19693">
                                 <rect width="16" height="16" fill="white" />
                             </clipPath>
                         </defs>
                     </svg>
                     {{ __('Deu List') }} </a>
                @endif

                @if (Route::currentRouteName() === 'business.purchases.create')
                <a data-bs-toggle="modal" data-bs-target="#bulk-upload-modal" href="{{ route('business.bulk-uploads.index') }}" class="deu-list-btn">
                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.75 2.0835H4.25C3.32952 2.0835 2.58333 2.82969 2.58333 3.75016V16.2502C2.58333 17.1707 3.32952 17.9168 4.25 17.9168H16.75C17.6705 17.9168 18.4167 17.1707 18.4167 16.2502V3.75016C18.4167 2.82969 17.6705 2.0835 16.75 2.0835Z" stroke="white" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7.58333 14.1665H13.4167" stroke="white" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.4167 8.75016L10.5 5.8335L7.58333 8.75016M10.5 6.66683V11.6668" stroke="white" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                     {{ __('Bulk Upload') }}
                </a>
                @endif
             </div>
         </div>
         <div class="header-middle"></div>
         <div class="header-right d-flex align-items-center gap-3">
             <div class="language-change">
                 <div class="dropdown">
                     <button class="language-dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown"
                         aria-expanded="false">
                         <img src="{{ asset('flags/' . languages()[app()->getLocale()]['flag'] . '.svg') }}"
                             alt="" class="flag-icon">
                         {{ languages()[app()->getLocale()]['name'] }}
                         <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                             <path
                                 d="M8.00002 11.1667C7.87202 11.1667 7.744 11.118 7.64666 11.02L2.98 6.35337C2.78466 6.15804 2.78466 5.84135 2.98 5.64601C3.17533 5.45068 3.49202 5.45068 3.68735 5.64601L8.00067 9.95933L12.314 5.64601C12.5093 5.45068 12.826 5.45068 13.0213 5.64601C13.2167 5.84135 13.2167 6.15804 13.0213 6.35337L8.35467 11.02C8.256 11.118 8.12802 11.1667 8.00002 11.1667Z"
                                 fill="white" />
                         </svg>
                     </button>
                     <ul class="dropdown-menu dropdown-menu-scroll">
                         @foreach (languages() as $key => $language)
                             <li class="language-li">
                                 <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['lang' => $key]) }}">
                                     <img src="{{ asset('flags/' . $language['flag'] . '.svg') }}" alt=""
                                         class="flag-icon me-2">
                                     {{ $language['name'] }}
                                 </a>
                                 @if (app()->getLocale() == $key)
                                     <i class="fas fa-check language-check"></i>
                                 @endif
                             </li>
                         @endforeach
                     </ul>
                 </div>
             </div>

             <div class="custom-notification-wrapper">
                 <a href="#" class="custom-notification-toggle" id="customNotificationToggle">
                     <i class="custom-notification-icon">
                         <img src="{{ asset('assets/images/icons/bel.svg') }}" alt="Notification">
                     </i>
                     <span class="custom-notification-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                 </a>

                 <div class="custom-notification-dropdown" id="customNotificationDropdown">
                     <div class="notification-header">
                         <p>{{ __('You Have') }} <strong>{{ auth()->user()->unreadNotifications->count() }}</strong>
                             {{ __('new Notifications') }}</p>
                         <a href="{{ route('business.notifications.mtReadAll') }}"
                             class="text-red">{{ __('Mark all Read') }}</a>
                     </div>
                     <ul class="custom-notification-list">
                         @foreach (auth()->user()->unreadNotifications as $notification)
                             <li class="custom-notification-item">
                                 <a href="{{ route('business.notifications.mtView', $notification->id) }}"
                                     class="custom-notification-link">
                                     <strong>{{ __($notification->data['message'] ?? '') }}</strong>
                                     <span
                                         class="custom-notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                 </a>
                             </li>
                         @endforeach
                     </ul>
                     <div class="custom-notification-footer">
                         <a href="{{ route('business.notifications.index') }}" class="custom-view-all">
                             {{ __('View all notifications') }}
                         </a>
                     </div>
                 </div>
             </div>


             <div class="d-flex align-items-center justify-content-center">
                 <div class="profile-info dropdown">
                     <a href="#" data-bs-toggle="dropdown">
                         <div class="d-flex align-items-center justify-content-center gap-2">
                             <img src="{{ asset(
                                 auth()->user()->role == 'staff'
                                     ? auth()->user()->business->pictureUrl ?? 'assets/images/icons/default-user.png'
                                     : auth()->user()->image ?? 'assets/images/icons/default-user.png',
                             ) }}"
                                 alt="Profile">
                         </div>
                     </a>
                     <div class=" business-profile bg-success">
                         <ul class="dropdown-menu">
                             <li> <a href="{{ route('business.profiles.index') }}"> <i class="fal fa-user"></i>
                                     {{ __('My Profile') }}</a></li>
                             <li>
                                 <a href="javascript:void(0)" class="logoutButton">
                                     <i class="far fa-sign-out"></i> {{ __('Logout') }}
                                     <form action="{{ route('logout') }}" method="post" id="logoutForm">
                                         @csrf
                                     </form>
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </div>
                  <div class="sidebar-opner menu-opener right-menu-opener"><i class="fal fa-bars" aria-hidden="true"></i></div>
             </div>
         </div>
     </div>
 </header>

@push('js')
    <script src="{{ asset('assets/js/custom/notification-dropdown-business.js') }}"></script>
@endpush
@push('modal')
    @include('businessAddon::purchases.bulk-upload.index')
@endpush
