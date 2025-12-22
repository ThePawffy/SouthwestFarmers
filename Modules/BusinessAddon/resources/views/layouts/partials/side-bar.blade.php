<nav class="side-bar">
    <div class="side-bar-logo sticky-top">
        <a href="{{ route('business.dashboard.index') }}">
            <img src="{{ asset(get_option('general')['business_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo">
        </a>
        <button class="close-btn"><i class="fal fa-times"></i></button>
    </div>

    <div class="side-bar-manu">

          <div class=" header-buttons-2  mx-1 ">
                @if (auth()->user()->role != 'staff' || visible_permission('salesListPermission'))
                 <a href="{{ route('business.sales.create') }}" class="pos-btn-2 ">
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

                @if (auth()->user()->role != 'staff' || visible_permission('dueListPermission'))
                 <a href="{{ route('business.dues.index') }}" class="deu-list-btn-2 ">
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
             </div>

        <ul>
            <li class="{{ Request::routeIs('business.dashboard.index') ? 'active' : '' }}">
                <a href="{{ route('business.dashboard.index') }}" class="active">
                    <span class="sidebar-icon">

                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5002 14.1667C11.8339 14.6854 10.9587 15.0001 10.0002 15.0001C9.04159 15.0001 8.16643 14.6854 7.50015 14.1667" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                        <path d="M1.95965 11.0113C1.66547 9.09691 1.51837 8.13977 1.8803 7.29123C2.24222 6.44268 3.04518 5.86211 4.65111 4.70096L5.85098 3.83341C7.84873 2.38897 8.84759 1.66675 10.0002 1.66675C11.1527 1.66675 12.1516 2.38897 14.1493 3.83341L15.3492 4.70096C16.9552 5.86211 17.7581 6.44268 18.12 7.29123C18.4819 8.13977 18.3348 9.09691 18.0407 11.0113L17.7898 12.6437C17.3728 15.3575 17.1643 16.7144 16.191 17.5239C15.2178 18.3334 13.7948 18.3334 10.9492 18.3334H9.05117C6.20544 18.3334 4.78258 18.3334 3.80932 17.5239C2.83607 16.7144 2.62755 15.3575 2.21052 12.6437L1.95965 11.0113Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                        </svg>


                    </span>
                    {{ __('Dashboard') }}
                </a>
            </li>
            @if (auth()->user()->role != 'staff' ||  visible_permission('salePermission') || visible_permission('salesListPermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.sales.index', 'business.sales.create', 'business.sales.edit', 'business.sale-returns.create', 'business.sale-returns.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                           <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.5833 4.16675C15.2737 4.16675 15.8333 4.72639 15.8333 5.41675C15.8333 6.10711 15.2737 6.66675 14.5833 6.66675C13.893 6.66675 13.3333 6.10711 13.3333 5.41675C13.3333 4.72639 13.893 4.16675 14.5833 4.16675Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2.31187 9.28666C1.47591 10.2203 1.45792 11.6289 2.22514 12.6198C3.7476 14.5862 5.41396 16.2525 7.38028 17.7749C8.37117 18.5422 9.77976 18.5242 10.7134 17.6882C13.2483 15.4186 15.5696 13.0467 17.8099 10.44C18.0314 10.1823 18.1699 9.8665 18.201 9.52808C18.3385 8.03173 18.621 3.72064 17.4503 2.54986C16.2794 1.37909 11.9683 1.66156 10.472 1.79905C10.1336 1.83015 9.81776 1.96869 9.56001 2.19017C6.95344 4.43046 4.58152 6.75184 2.31187 9.28666Z" stroke="#4D4D4D" stroke-width="1.25"/>
                            <path d="M11.4903 10.3055C11.5081 9.97136 11.6018 9.36003 11.0937 8.89545M11.0937 8.89545C10.9365 8.7517 10.7217 8.62195 10.4291 8.51878C9.38191 8.14973 8.0957 9.38503 9.00558 10.5158C9.49466 11.1235 9.87175 11.3105 9.83625 12.0007C9.81125 12.4863 9.33433 12.9935 8.70575 13.1868C8.15966 13.3546 7.5573 13.1324 7.1763 12.7066C6.7111 12.1869 6.75808 11.6968 6.7541 11.4832M11.0937 8.89545L11.6672 8.32202M7.21776 12.7714L6.67317 13.316" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>


                        </span>
                        {{ __('Sales') }}</a>
                    <ul>
                        @if (auth()->user()->role != 'staff' ||  visible_permission('salePermission'))
                        <li><a class="{{ Request::routeIs('business.sales.create') ? 'active' : '' }}"
                                href="{{ route('business.sales.create') }}">{{ __('Pos') }}</a></li>
                        @endif
                        @if (auth()->user()->role != 'staff' || visible_permission('salesListPermission'))
                        <li><a class="{{ Request::routeIs('business.sales.index', 'business.sale-returns.create') ? 'active' : '' }}"
                                href="{{ route('business.sales.index') }}">{{ __('Sale List') }}</a></li>
                        <li><a class="{{ Request::routeIs('business.sale-returns.index') ? 'active' : '' }}"
                                href="{{ route('business.sale-returns.index') }}">{{ __('Sales Return') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('purchasePermission') || visible_permission('purchaseListPermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.purchases.index', 'business.purchases.create', 'business.purchases.edit', 'business.purchase-returns.create', 'business.purchase-returns.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">

                           <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.66667 13.3333L13.9334 12.7277C16.2072 12.5383 16.7176 12.0417 16.9696 9.77408L17.5 5" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                            <path d="M5 5H6.25M18.3333 5H15.8333" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                            <path d="M8.75 5.83333C8.75 5.83333 9.58333 5.83333 10.4167 7.5C10.4167 7.5 13.0637 3.33333 15.4167 2.5" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4.99999 18.3333C5.92047 18.3333 6.66666 17.5871 6.66666 16.6667C6.66666 15.7462 5.92047 15 4.99999 15C4.07952 15 3.33333 15.7462 3.33333 16.6667C3.33333 17.5871 4.07952 18.3333 4.99999 18.3333Z" stroke="#4D4D4D" stroke-width="1.25"/>
                            <path d="M14.1667 18.3333C15.0871 18.3333 15.8333 17.5871 15.8333 16.6667C15.8333 15.7462 15.0871 15 14.1667 15C13.2462 15 12.5 15.7462 12.5 16.6667C12.5 17.5871 13.2462 18.3333 14.1667 18.3333Z" stroke="#4D4D4D" stroke-width="1.25"/>
                            <path d="M6.66667 16.6667H12.5" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                            <path d="M1.66667 1.66675H2.47167C3.25891 1.66675 3.94512 2.18724 4.13606 2.92919L6.61544 12.5638C6.74073 13.0507 6.63351 13.5665 6.32354 13.9681L5.52678 15.0001" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                            </svg>


                        </span>
                        {{ __('Purchases') }}</a>
                    <ul>
                        @if (auth()->user()->role != 'staff' || visible_permission('purchasePermission'))
                        <li><a class="{{ Request::routeIs('business.purchases.create') ? 'active' : '' }}"
                                href="{{ route('business.purchases.create') }}">{{ __('Purchase New') }}</a></li>
                        @endif
                        @if (auth()->user()->role != 'staff' || visible_permission('purchaseListPermission'))
                        <li><a class="{{ Request::routeIs('business.purchases.index',  'business.purchase-returns.create') ? 'active' : '' }}"
                                href="{{ route('business.purchases.index') }}">{{ __('Purchase List') }}</a></li>
                        <li><a class="{{ Request::routeIs('business.purchase-returns.index') ? 'active' : '' }}"
                                href="{{ route('business.purchase-returns.index') }}">{{ __('Purchase Return') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->role != 'staff' || visible_permission('productPermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.products.index', 'business.products.create', 'business.products.edit', 'business.categories.index', 'business.brands.index', 'business.units.index', 'business.barcodes.index', 'business.bulk-uploads.index','business.expired-products.index','business.product-models.index','business.products.show') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                           <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.5 10.9389V7.1001H17V10.9389C17 13.7962 17 15.2248 16.1213 16.1124C15.2427 17.0001 13.8284 17.0001 11 17.0001H9.50003C6.67157 17.0001 5.25736 17.0001 4.37868 16.1124C3.5 15.2248 3.5 13.7962 3.5 10.9389Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3.5 7.1L4.14903 5.71539C4.6524 4.64154 4.90408 4.10462 5.41423 3.80231C5.92438 3.5 6.57876 3.5 7.8875 3.5H12.6125C13.9213 3.5 14.5756 3.5 15.0858 3.80231C15.5959 4.10462 15.8476 4.64154 16.3509 5.71539L17 7.1" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                            <path d="M8.89999 9.80005H11.6" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                            </svg>


                        </span>
                        {{ __('Products') }}</a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.products.index') ? 'active' : '' }}"
                                href="{{ route('business.products.index') }}">{{ __('All Product') }}</a>
                        </li>
                        <li><a class="{{ Request::routeIs('business.products.create') ? 'active' : '' }}"
                                href="{{ route('business.products.create') }}">{{ __('Add Product') }}</a>
                        </li>
                        <li><a class="{{ Request::routeIs('business.expired-products.index') ? 'active' : '' }}"
                               href="{{ route('business.expired-products.index') }}">{{ __('Expired Products') }}</a>
                        </li>
                        <li>
                            <a class="{{ Request::routeIs('business.barcodes.index') ? 'active' : '' }}"
                               href="{{ route('business.barcodes.index') }}">{{ __('Print Labels') }}</a>
                        </li>
                        <li>
                            <a class="{{ Request::routeIs('business.bulk-uploads.index') ? 'active' : '' }}"
                               href="{{ route('business.bulk-uploads.index') }}">{{ __('Bulk Upload') }}</a>
                        </li>
                        <li>
                            <a class="{{ Request::routeIs('business.categories.index') ? 'active' : '' }}"
                                href="{{ route('business.categories.index') }}">{{ __('Category') }}</a>
                        </li>
                        <li>
                            <a class="{{ Request::routeIs('business.brands.index') ? 'active' : '' }}"
                                href="{{ route('business.brands.index') }}">{{ __('Brand') }}</a>
                        </li>
                        <li>
                            <a class="{{ Request::routeIs('business.units.index') ? 'active' : '' }}"
                                href="{{ route('business.units.index') }}">{{ __('Unit') }}</a>
                        </li>
                         <li>
                            <a class="{{ Request::routeIs('business.product-models.index') ? 'active' : '' }}"
                                href="{{ route('business.product-models.index') }}">{{ __('Model') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('stockPermission'))
                <li class="dropdown {{ Request::routeIs('business.stocks.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.08333 9.99992C2.08333 6.26797 2.08333 4.40199 3.24269 3.24262C4.40207 2.08325 6.26804 2.08325 9.99999 2.08325C13.7319 2.08325 15.5979 2.08325 16.7573 3.24262C17.9167 4.40199 17.9167 6.26797 17.9167 9.99992C17.9167 13.7318 17.9167 15.5978 16.7573 16.7573C15.5979 17.9166 13.7319 17.9166 9.99999 17.9166C6.26804 17.9166 4.40207 17.9166 3.24269 16.7573C2.08333 15.5978 2.08333 13.7318 2.08333 9.99992Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                            <path d="M9.16666 6.24992H14.1667M6.66666 6.24992C6.66666 6.48004 6.48011 6.66659 6.24999 6.66659C6.01988 6.66659 5.83333 6.48004 5.83333 6.24992C5.83333 6.0198 6.01988 5.83325 6.24999 5.83325C6.48011 5.83325 6.66666 6.0198 6.66666 6.24992Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.16666 9.99992H14.1667M6.66666 9.99992C6.66666 10.23 6.48011 10.4166 6.24999 10.4166C6.01988 10.4166 5.83333 10.23 5.83333 9.99992C5.83333 9.76984 6.01988 9.58325 6.24999 9.58325C6.48011 9.58325 6.66666 9.76984 6.66666 9.99992Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.16666 13.7499H14.1667M6.66666 13.7499C6.66666 13.98 6.48011 14.1666 6.24999 14.1666C6.01988 14.1666 5.83333 13.98 5.83333 13.7499C5.83333 13.5198 6.01988 13.3333 6.24999 13.3333C6.48011 13.3333 6.66666 13.5198 6.66666 13.7499Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                        </span>
                        {{ __('Stock List') }}
                    </a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.stocks.index') && !request('alert_qty')  ? 'active' : '' }}"
                               href="{{ route('business.stocks.index') }}">{{ __('All Stock') }}</a></li>
                        <li><a class="{{ Request::routeIs('business.stocks.index') && request('alert_qty') ? 'active' : '' }}"
                               href="{{ route('business.stocks.index', ['alert_qty' => true]) }}">{{ __('Low Stock') }}</a></li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->role != 'staff' || visible_permission('partiesPermission'))
                <li
                    class="dropdown {{ (Request::routeIs('business.parties.index') && request('type') == 'Customer') || (Request::routeIs('business.parties.create') && request('type') == 'Customer') || (Request::routeIs('business.parties.edit') && request('type') == 'Customer') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </span>
                        {{ __('Customers') }}
                    </a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.parties.index') && request('type') == 'Customer' ? 'active' : '' }}"
                                href="{{ route('business.parties.index', ['type' => 'Customer']) }}">{{ __('All Customers') }}</a>
                        </li>
                        <li><a class="{{ Request::routeIs('business.parties.create') && request('type') == 'Customer' ? 'active' : '' }}"
                                href="{{ route('business.parties.create', ['type' => 'Customer']) }}">{{ __('Add Customer') }}</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="dropdown {{ (Request::routeIs('business.parties.index') && request('type') == 'Supplier') || (Request::routeIs('business.parties.create') && request('type') == 'Supplier') || (Request::routeIs('business.parties.edit') && request('type') == 'Supplier') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </span>
                        {{ __('Suppliers') }}
                    </a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.parties.index') && request('type') == 'Supplier' ? 'active' : '' }}"
                                href="{{ route('business.parties.index', ['type' => 'Supplier']) }}">{{ __('All Suppliers') }}</a>
                        </li>
                        <li><a class="{{ Request::routeIs('business.parties.create') && request('type') == 'Supplier' ? 'active' : '' }}"
                                href="{{ route('business.parties.create', ['type' => 'Supplier']) }}">{{ __('Add Supplier') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->role != 'staff' || visible_permission('addIncomePermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.incomes.index', 'business.income-categories.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                           <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4522 14.0295C16.9053 10.7389 15.2027 8.28848 13.7225 6.84921C13.2917 6.43039 13.0764 6.22098 12.6007 6.02718C12.1249 5.83337 11.716 5.83337 10.8982 5.83337H9.10183C8.28401 5.83337 7.87508 5.83337 7.39935 6.02718C6.92361 6.22098 6.70826 6.43039 6.27753 6.84921C4.79735 8.28848 3.09467 10.7389 2.54772 14.0295C2.14077 16.4779 4.39939 18.3334 6.9236 18.3334H13.0764C15.6006 18.3334 17.8592 16.4779 17.4522 14.0295Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.04718 3.70235C5.87525 3.45211 5.62606 3.11245 6.14082 3.035C6.66993 2.95538 7.21934 3.31758 7.75712 3.31013C8.24364 3.3034 8.49149 3.08762 8.75741 2.77953C9.03741 2.4551 9.47099 1.66663 9.99999 1.66663C10.529 1.66663 10.9626 2.4551 11.2426 2.77953C11.5085 3.08762 11.7563 3.3034 12.2428 3.31013C12.7807 3.31758 13.3301 2.95538 13.8592 3.035C14.3739 3.11245 14.1247 3.45211 13.9528 3.70235L13.1754 4.83383C12.8429 5.31784 12.6767 5.55985 12.3287 5.69658C11.9807 5.83329 11.5311 5.83329 10.6318 5.83329H9.36816C8.46891 5.83329 8.01924 5.83329 7.67129 5.69658C7.32334 5.55985 7.15708 5.31784 6.82454 4.83383L6.04718 3.70235Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                            <path d="M11.3556 10.7656C11.1754 10.1005 10.2584 9.50031 9.15767 9.94931C8.05691 10.3982 7.88207 11.8428 9.54709 11.9963C10.2996 12.0656 10.7903 11.9158 11.2394 12.3397C11.6887 12.7636 11.7721 13.9424 10.6238 14.2601C9.47542 14.5777 8.33834 14.0814 8.21452 13.3765M9.86809 9.16064V9.79431M9.86809 14.3578V14.994" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>


                        </span>
                        {{ __('Incomes') }}</a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.incomes.index') ? 'active' : '' }}"
                                href="{{ route('business.incomes.index') }}">{{ __('Income') }}</a></li>

                        <li><a class="{{ Request::routeIs('business.income-categories.index') ? 'active' : '' }}"
                                href="{{ route('business.income-categories.index') }}">{{ __('Income Category') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->role != 'staff' || visible_permission('addExpensePermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.expense-categories.index', 'business.expenses.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                           <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.83334 5.55846C4.94507 5.55846 4.09975 5.45903 3.33334 5.27963C2.53336 5.09237 1.66667 5.66845 1.66667 6.50718V15.6813C1.66667 16.3549 1.66667 16.6918 1.82844 17.0391C1.9207 17.2372 2.13081 17.5067 2.29916 17.6429C2.59433 17.8815 2.84067 17.9392 3.33334 18.0545C4.09975 18.2339 4.94507 18.3334 5.83334 18.3334C7.4309 18.3334 8.88959 18.0118 10 17.4817C11.1104 16.9517 12.5691 16.63 14.1667 16.63C15.0549 16.63 15.9003 16.7294 16.6667 16.9089C17.4667 17.0961 18.3333 16.52 18.3333 15.6813V6.50718C18.3333 5.83354 18.3333 5.49672 18.1716 5.14937C18.0793 4.95127 17.8692 4.68179 17.7008 4.54566C16.6667 3.69897 15 4.53522 15 4.53522" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                            <path d="M12.0833 11.25C12.0833 12.4005 11.1506 13.3333 10 13.3333C8.84942 13.3333 7.91667 12.4005 7.91667 11.25C7.91667 10.0994 8.84942 9.16663 10 9.16663C11.1506 9.16663 12.0833 10.0994 12.0833 11.25Z" stroke="#4D4D4D" stroke-width="1.25"/>
                            <path d="M4.58333 12.0834V12.0909" stroke="#4D4D4D" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15.4167 10.4102V10.4177" stroke="#4D4D4D" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M7.91667 3.74996C8.32628 3.32854 9.41651 1.66663 10 1.66663M10 1.66663C10.5835 1.66663 11.6738 3.32854 12.0833 3.74996M10 1.66663V6.66663" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>


                        </span>
                        {{ __('Expenses') }}</a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.expenses.index') ? 'active' : '' }}"
                                href="{{ route('business.expenses.index') }}">{{ __('Expense') }}</a></li>

                        <li><a class="{{ Request::routeIs('business.expense-categories.index') ? 'active' : '' }}"
                                href="{{ route('business.expense-categories.index') }}">{{ __('Expense Category') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('addVatPermission'))
            <li class="{{ Request::routeIs('business.vats.index', 'business.vats.edit', 'business.vats.create') ? 'active' : '' }}">
                <a href="{{ route('business.vats.index') }}" class="active">
                    <span class="sidebar-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
                    </span>
                    {{ __('Vat & Tax') }}
                </a>
            </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('dueListPermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.dues.index', 'business.collect.dues', 'business.walk-dues.index','business.collect.walk.dues') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.25004 2.9165C4.95354 2.9554 4.18055 3.0997 3.64569 3.63506C2.91345 4.36798 2.91345 5.54759 2.91345 7.9068V13.3285C2.91345 15.6878 2.91345 16.8673 3.64569 17.6003C4.37792 18.3332 5.55644 18.3332 7.91345 18.3332H12.0801C14.4371 18.3332 15.6156 18.3332 16.3479 17.6003C17.0801 16.8673 17.0801 15.6878 17.0801 13.3285V7.9068C17.0801 5.54759 17.0801 4.36798 16.3479 3.63507C15.813 3.0997 15.04 2.9554 13.7435 2.9165" stroke="white" stroke-width="1.3"/>
                            <path d="M6.2467 3.12484C6.2467 2.31942 6.89963 1.6665 7.70504 1.6665H12.2884C13.0938 1.6665 13.7467 2.31942 13.7467 3.12484C13.7467 3.93025 13.0938 4.58317 12.2884 4.58317H7.70504C6.89963 4.58317 6.2467 3.93025 6.2467 3.12484Z" stroke="white" stroke-width="1.3" stroke-linejoin="round"/>
                            <path d="M11.25 9.1665H14.1667" stroke="white" stroke-width="1.3" stroke-linecap="round"/>
                            <path d="M5.83337 10.0002C5.83337 10.0002 6.25004 10.0002 6.66671 10.8335C6.66671 10.8335 7.99024 8.75016 9.16671 8.3335" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.25 14.1665H14.1667" stroke="white" stroke-width="1.3" stroke-linecap="round"/>
                            <path d="M6.66663 14.1665H7.49996" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        {{ __('Due List') }}</a>
                        <ul>
                            <li>
                                <a class="{{ Request::routeIs('business.dues.index') || (Request::routeIs('business.collect.dues') && request('source') != 'walk-in') ? 'active' : '' }}"
                                   href="{{ route('business.dues.index') }}">
                                    {{ __('All Due') }}
                                </a>
                            </li>

                            <li>
                                <a class="{{ Request::routeIs('business.walk-dues.index','business.collect.walk.dues') ? 'active' : '' }}"
                                   href="{{ route('business.walk-dues.index') }}">
                                    {{ __('Cash Due') }}
                                </a>
                            </li>
                        </ul>
                </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('addSubscriptionPermission'))
            <li class="{{ Request::routeIs('business.subscriptions.index') ? 'active' : '' }}">
                <a href="{{ route('business.subscriptions.index') }}" class="active">
                    <span class="sidebar-icon">
                       <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.4167 14.1667V5.83333C15.4167 4.26198 15.4167 3.47631 14.9285 2.98816C14.4403 2.5 13.6547 2.5 12.0833 2.5H7.91666C6.34531 2.5 5.55964 2.5 5.07149 2.98816C4.58333 3.47631 4.58333 4.26198 4.58333 5.83333V14.1667C4.58333 15.738 4.58333 16.5237 5.07149 17.0118C5.55964 17.5 6.34531 17.5 7.91666 17.5H12.0833C13.6547 17.5 14.4403 17.5 14.9285 17.0118C15.4167 16.5237 15.4167 15.738 15.4167 14.1667Z" stroke="#4D4D4D" stroke-width="1.25"/>
                        <path d="M15.4167 5H15.8333C17.0118 5 17.6011 5 17.9673 5.36612C18.3333 5.73223 18.3333 6.32149 18.3333 7.5V13.3333C18.3333 14.5118 18.3333 15.1011 17.9673 15.4672C17.6011 15.8333 17.0118 15.8333 15.8333 15.8333H15.4167" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                        <path d="M4.58334 5H4.16667C2.98816 5 2.39891 5 2.03279 5.36612C1.66667 5.73223 1.66667 6.32149 1.66667 7.5V13.3333C1.66667 14.5118 1.66667 15.1011 2.03279 15.4672C2.39891 15.8333 2.98816 15.8333 4.16667 15.8333H4.58334" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                        <path d="M12.0833 6.66663H7.91667M12.0833 9.99996H7.91667M12.0833 13.3333H7.91667" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                        </svg>


                    </span>
                    {{ __('Subscriptions') }}
                </a>
            </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('lossProfitPermission'))
                <li class="{{ Request::routeIs('business.loss-profits.index') ? 'active' : '' }}">
                    <a href="{{ route('business.loss-profits.index') }}" class="active">
                        <span class="sidebar-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.0833 8.75V16.25C17.0833 16.6382 17.0833 16.8324 17.0199 16.9856C16.9353 17.1897 16.7731 17.352 16.5689 17.4366C16.4157 17.5 16.2216 17.5 15.8333 17.5C15.4451 17.5 15.2509 17.5 15.0977 17.4366C14.8936 17.352 14.7313 17.1897 14.6467 16.9856C14.5833 16.8324 14.5833 16.6382 14.5833 16.25V8.75C14.5833 8.36175 14.5833 8.16758 14.6467 8.01443C14.7313 7.81024 14.8936 7.64801 15.0977 7.56343C15.2509 7.5 15.4451 7.5 15.8333 7.5C16.2216 7.5 16.4157 7.5 16.5689 7.56343C16.7731 7.64801 16.9353 7.81024 17.0199 8.01443C17.0833 8.16758 17.0833 8.36175 17.0833 8.75Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                            <path d="M13.75 2.5H16.25V5" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15.8333 2.91675C15.8333 2.91675 12.5 7.08341 3.75 10.0001" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.25 11.6667V16.2501C11.25 16.6383 11.25 16.8325 11.1866 16.9857C11.102 17.1898 10.9397 17.3521 10.7356 17.4367C10.5824 17.5001 10.3882 17.5001 10 17.5001C9.61175 17.5001 9.41758 17.5001 9.26442 17.4367C9.06025 17.3521 8.898 17.1898 8.81342 16.9857C8.75 16.8325 8.75 16.6383 8.75 16.2501V11.6667C8.75 11.2785 8.75 11.0843 8.81342 10.9312C8.898 10.727 9.06025 10.5647 9.26442 10.4802C9.41758 10.4167 9.61175 10.4167 10 10.4167C10.3882 10.4167 10.5824 10.4167 10.7356 10.4802C10.9397 10.5647 11.102 10.727 11.1866 10.9312C11.25 11.0843 11.25 11.2785 11.25 11.6667Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                            <path d="M5.41667 13.75V16.25C5.41667 16.6382 5.41667 16.8324 5.35324 16.9856C5.26866 17.1897 5.10643 17.352 4.90224 17.4366C4.7491 17.5 4.55496 17.5 4.16667 17.5C3.77839 17.5 3.58425 17.5 3.43111 17.4366C3.22691 17.352 3.06468 17.1897 2.98011 16.9856C2.91667 16.8324 2.91667 16.6382 2.91667 16.25V13.75C2.91667 13.3617 2.91667 13.1676 2.98011 13.0144C3.06468 12.8103 3.22691 12.648 3.43111 12.5634C3.58425 12.5 3.77839 12.5 4.16667 12.5C4.55496 12.5 4.7491 12.5 4.90224 12.5634C5.10643 12.648 5.26866 12.8103 5.35324 13.0144C5.41667 13.1676 5.41667 13.3617 5.41667 13.75Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                            </svg>

                        </span>
                        {{ __('Loss/Profit') }}
                    </a>
                </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('reportsPermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.income-reports.index', 'business.expense-reports.index', 'business.stock-reports.index', 'business.loss-profit-reports.index', 'business.sale-reports.index', 'business.purchase-reports.index', 'business.due-reports.index', 'business.sale-return-reports.index', 'business.purchase-return-reports.index', 'business.supplier-due-reports.index', 'business.transaction-history-reports.index', 'business.subscription-reports.index', 'business.expired-product-reports.index','business.vat-reports.index', 'business.loss-profit-reports.details') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                           <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.83333 14.1667V10.8334" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                            <path d="M10 14.1667V5.83337" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                            <path d="M14.1667 14.1666V9.16663" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                            <path d="M2.08333 10C2.08333 6.26809 2.08333 4.40212 3.24269 3.24274C4.40207 2.08337 6.26804 2.08337 9.99999 2.08337C13.7319 2.08337 15.5979 2.08337 16.7573 3.24274C17.9167 4.40212 17.9167 6.26809 17.9167 10C17.9167 13.732 17.9167 15.598 16.7573 16.7574C15.5979 17.9167 13.7319 17.9167 9.99999 17.9167C6.26804 17.9167 4.40207 17.9167 3.24269 16.7574C2.08333 15.598 2.08333 13.732 2.08333 10Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        {{ __('Reports') }}</a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.sale-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.sale-reports.index') }}">{{ __('Sale') }}</a></li>

                        <li><a class="{{ Request::routeIs('business.sale-return-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.sale-return-reports.index') }}">{{ __('Sale Return') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.purchase-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.purchase-reports.index') }}">{{ __('Purchase') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.purchase-return-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.purchase-return-reports.index') }}">{{ __('Purchase Return') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.vat-reports.index') ? 'active' : '' }}"
                            href="{{ route('business.vat-reports.index') }}">{{ __('Vat Report') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.loss-profit-reports.details') ? 'active' : '' }}"
                               href="{{ route('business.loss-profit-reports.details') }}">{{ __('Loss/Profit Details') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.income-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.income-reports.index') }}">{{ __('All Income') }}</a></li>

                        <li><a class="{{ Request::routeIs('business.expense-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.expense-reports.index') }}">{{ __('All Expense') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.stock-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.stock-reports.index') }}">{{ __('Current Stock') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.due-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.due-reports.index') }}">{{ __('Customer Due') }}</a></li>

                        <li><a class="{{ Request::routeIs('business.supplier-due-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.supplier-due-reports.index') }}">{{ __('Supplier Due') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.loss-profit-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.loss-profit-reports.index') }}">{{ __('Loss & Profit') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.transaction-history-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.transaction-history-reports.index') }}">{{ __('Transaction') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.subscription-reports.index') ? 'active' : '' }}"
                            href="{{ route('business.subscription-reports.index') }}">{{ __('Subscription Report') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.expired-product-reports.index') ? 'active' : '' }}"
                            href="{{ route('business.expired-product-reports.index') }}">{{ __('Expired Product') }}</a>
                        </li>

                    </ul>
                </li>
            @endif

            @if (auth()->user()->role != 'staff')
                <li
                    class="dropdown {{ Request::routeIs('business.settings.index', 'business.roles.index', 'business.roles.edit', 'business.roles.create', 'business.currencies.index', 'business.currencies.create', 'business.currencies.edit', 'business.notifications.index','business.payment-types.index','business.invoice.index','business.product.setting.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                           <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.9167 10C12.9167 11.6109 11.6108 12.9167 9.99999 12.9167C8.38916 12.9167 7.08333 11.6109 7.08333 10C7.08333 8.38921 8.38916 7.08337 9.99999 7.08337C11.6108 7.08337 12.9167 8.38921 12.9167 10Z" stroke="#4D4D4D" stroke-width="1.25"/>
                            <path d="M17.5092 11.7471C17.9441 11.6298 18.1616 11.5712 18.2474 11.459C18.3333 11.3469 18.3333 11.1665 18.3333 10.8058V9.19435C18.3333 8.8336 18.3333 8.65318 18.2474 8.5411C18.1615 8.42893 17.9441 8.37026 17.5092 8.253C15.8838 7.81467 14.8666 6.11544 15.2861 4.50074C15.4014 4.05667 15.4591 3.83465 15.404 3.70442C15.3489 3.5742 15.1909 3.48446 14.8748 3.30498L13.4375 2.48896C13.1273 2.31284 12.9723 2.22478 12.8331 2.24353C12.6938 2.26228 12.5368 2.41896 12.2227 2.73229C11.0067 3.94541 8.99467 3.94536 7.77862 2.73221C7.46453 2.41887 7.30749 2.26221 7.16828 2.24345C7.02908 2.2247 6.87398 2.31276 6.56378 2.48887L5.12654 3.30491C4.81045 3.48437 4.6524 3.57411 4.59732 3.70431C4.54224 3.83451 4.5999 4.05657 4.71521 4.50068C5.13448 6.11543 4.11644 7.81471 2.49086 8.25301C2.05594 8.37026 1.83848 8.42893 1.75257 8.54101C1.66667 8.65318 1.66667 8.8336 1.66667 9.19435V10.8058C1.66667 11.1665 1.66667 11.3469 1.75257 11.459C1.83846 11.5712 2.05593 11.6298 2.49086 11.7471C4.11617 12.1854 5.13341 13.8847 4.71394 15.4993C4.59858 15.9434 4.5409 16.1654 4.59597 16.2957C4.65106 16.4259 4.8091 16.5157 5.12521 16.6951L6.56246 17.5112C6.87268 17.6873 7.02779 17.7753 7.167 17.7566C7.30622 17.7378 7.46324 17.5811 7.77726 17.2678C8.99392 16.0537 11.0073 16.0536 12.2241 17.2677C12.5381 17.5811 12.6951 17.7378 12.8343 17.7565C12.9735 17.7753 13.1287 17.6872 13.4388 17.5111L14.8761 16.695C15.1923 16.5156 15.3503 16.4258 15.4053 16.2956C15.4604 16.1653 15.4028 15.9433 15.2873 15.4993C14.8677 13.8847 15.8841 12.1855 17.5092 11.7471Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round"/>
                            </svg>

                        </span>
                        {{ __('Settings') }}
                    </a>
                    <ul>

                        <li>
                            <a class="{{ Request::routeIs('business.currencies.index', 'business.currencies.create', 'business.currencies.edit') ? 'active' : '' }}"
                                href="{{ route('business.currencies.index') }}">{{ __('Currencies') }}</a>
                        </li>

                        <li>
                            <a class="{{ Request::routeIs('business.notifications.index') ? 'active' : '' }}"
                                href="{{ route('business.notifications.index') }}">{{ __('Notifications') }}</a>
                        </li>


                        <li>
                            <a class="{{ Request::routeIs('business.settings.index') ? 'active' : '' }}"
                                href="{{ route('business.settings.index') }}">{{ __('General Settings') }}</a>
                        </li>

                        <li>
                            <a class="{{ Request::routeIs('business.invoice.index') ? 'active' : '' }}"
                                href="{{ route('business.invoice.index') }}">{{ __('Invoice Settings') }}</a>
                        </li>

                        <li>
                            <a class="{{ Request::routeIs('business.product.setting.index') ? 'active' : '' }}"
                                href="{{ route('business.product.setting.index') }}">{{ __('Product Settings') }}</a>
                        </li>

                        <li>
                            <a class="{{ Request::routeIs('business.roles.index', 'business.roles.create', 'business.roles.edit') ? 'active' : '' }}"
                                href="{{ route('business.roles.index') }}">{{ __('User Role') }}</a>
                        </li>

                        <li>
                            <a class="{{ Request::routeIs('business.payment-types.index') ? 'active' : '' }}"
                                href="{{ route('business.payment-types.index') }}">{{ __('Payment Type') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('addDownloadapkPermission'))
            <li>
                <a href="{{ get_option('general')['app_link'] ?? '' }}" target="_blank" class="active">
                    <span class="sidebar-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0-3-3m3 3 3-3m-8.25 6a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                        </svg>
                    </span>
                    {{ __('Download Apk') }}
                </a>
            </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('addUpgradePlanPermission'))
            <li>
                <div class="lg-sub-plan">
                    <div id="sidebar_plan" class="d-block sidebar-free-plan d-flex align-items-center justify-content-between p-3 flex-column">
                        <div class="text-center">
                            @if (plan_data() ?? false)

                                <h3>
                                    {{ plan_data()['plan']['subscriptionName'] ?? ''}}
                                </h3>
                                <h5>
                                    {{ __('Expired') }}: {{ formatted_date(plan_data()['will_expire'] ?? '') }}
                                </h5>
                                @else
                                <h3>{{ __('No Active Plan') }}</h3>
                                <h5>{{ __('Please subscribe to a plan') }}</h5>
                            @endif

                        </div>
                        <a href="{{ route('business.subscriptions.index') }}" class="btn upgrate-btn fw-bold">{{ __('Upgrade Now') }}</a>
                    </div>
                </div>
            </li>
            @endif

            <li>
                <div class="sm-sidebar-plan">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6512 1.6279C12.5177 1.39421 12.2692 1.25 12 1.25C11.7309 1.25 11.4824 1.39421 11.3488 1.6279L7.67263 8.06127L3.27857 6.30364C3.01706 6.19904 2.719 6.24977 2.50682 6.43498C2.29464 6.62019 2.20411 6.90866 2.27242 7.1819L5.41444 18.75H18.5856L21.7276 7.1819C21.7959 6.90866 21.7054 6.62019 21.4932 6.43498C21.281 6.24977 20.983 6.19904 20.7215 6.30364L16.3274 8.06127L12.6512 1.6279ZM13 13H11V15H13V13Z" fill="white"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.5 22.75H5.5V20.75H18.5V22.75Z" fill="white"/>
                    </svg>
                </div>
            </li>

        </ul>
    </div>
</nav>
