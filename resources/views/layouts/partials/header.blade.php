<header class="main-header-section admin-header sticky-top">
    <div class="header-wrapper">
        <div class="header-left">
            <div class="sidebar-opner"><i class="fal fa-bars" aria-hidden="true"></i></div>
            <a target="_blank" class="text-custom-primary view-website" href="{{ route('home') }}">
                {{ __('View Website') }}
                <i class="fas fa-chevron-double-right"></i>
            </a>
        </div>
        <div class="header-middle"></div>
        <div class="header-right">
            <div class="language-change">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('flags/' . languages()[app()->getLocale()]['flag'] . '.svg') }}" alt="" class="flag-icon me-2">
                        {{ languages()[app()->getLocale()]['name'] }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-scroll">
                        @foreach (languages() as $key => $language)
                            <li class="language-li">
                                <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['lang' => $key]) }}">
                                    <img src="{{ asset('flags/' . $language['flag'] . '.svg') }}" alt="" class="flag-icon me-2">
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
            @if (auth()->user()->role == 'superadmin')
           <div class="custom-notification-wrapper">
    <a href="#" class="custom-notification-toggle mt-1 me-3">
        <i class="custom-notification-icon">
            <img src="{{ asset('assets/images/icons/bel2.svg') }}" alt="Notification">
        </i>
        <span class="custom-notification-count">
            {{ auth()->user()->unreadNotifications->count() }}
        </span>
    </a>

    <div class="custom-notification-dropdown">
       <div class="notification-header">
                        <p>{{ __('You Have') }} <strong>{{ auth()->user()->unreadNotifications->count() }}</strong> {{ __('new Notifications') }}</p>
                        <a href="{{ route('admin.notifications.mtReadAll') }}" class="text-red">{{ __('Mark all Read') }}</a>
                    </div>

        <ul class="custom-notification-list">
            @foreach (auth()->user()->unreadNotifications as $notification)
                <li class="custom-notification-item">
                    <a href="{{ route('admin.notifications.mtView', $notification->id) }}" class="custom-notification-link">
                        <strong>{{ __($notification->data['message'] ?? '') }}</strong>
                        <span class="custom-notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="custom-notification-footer">
            <a href="{{ route('admin.notifications.index') }}" class="custom-notification-view-all text-red">
                {{ __('View all notifications') }}
            </a>
        </div>
    </div>
</div>

            @endif
            <div class="profile-info dropdown">
                <a href="#"  data-bs-toggle="dropdown">
                    <img src="{{ asset(Auth::user()->image ?? 'assets/images/icons/default-user.png') }}" alt="Profile">
                </a>
                <ul class="dropdown-menu">
                    <li> <a href="{{ url('cache-clear') }}"> <i class="far fa-undo"></i> {{ __('Clear cache') }}</a></li>
                    <li> <a href="{{ route('admin.profiles.index') }}"> <i class="fal fa-user"></i> {{__('My Profile')}}</a></li>
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
    </div>
</header>

<script>

</script>

@push('js')
    <script src="{{ asset('assets/js/custom/notification-dropdown-admin.js') }}"></script>
@endpush
