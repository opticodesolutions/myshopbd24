@php
    $user = auth()->user();
    //User info
    $customer = \App\Models\Customer::where('user_id', $user->id)->first();
    $role = null;

    if ($user->hasRole('super-admin')) {
        $role = 'super-admin';
    } elseif ($user->hasRole('admin')) {
        $role = 'admin';
    } elseif ($user->hasRole('agent')) {
        $role = 'agent';
    } elseif ($user->hasRole('user')) {
        $role = 'user';
    }
@endphp
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ url($role) }}">
            <span class="sidebar-brand-text align-middle">
                MyShopBd24
                <sup>
                    {{ $user->name }}
                </sup>
            </span>
            <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5"
                stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
                <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
                <path d="M20 12L12 16L4 12"></path>
                <path d="M20 16L12 20L4 16"></path>
            </svg>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route($role)}}">
                    <i class="align-middle" data-feather="sliders"></i>  <span class="align-middle">Dashboard</span>
                </a>
            </li>
            @if($role == 'super-admin')
                <li class="sidebar-header pt-0">
                    Main
                </li>
                <li class="sidebar-item">
                    <a data-bs-target="#product" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Products</span>
                    </a>
                    <ul id="product" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                        <li class="sidebar-item"><a class='sidebar-link' href='{{ route('products.create') }}'>Create Product</a></li>
                        <li class="sidebar-item">
                            <a class='sidebar-link' href='{{ route('products.index') }}'>List Product</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a data-bs-target="#category" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Categories</span>
                    </a>
                    <ul id="category" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('categories.create') }}">Create Category</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('categories.index') }}">List Categories</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a data-bs-target="#Brand" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Brands</span>
                    </a>
                    <ul id="Brand" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                        <li class="sidebar-item"><a class='sidebar-link' href='{{ route('brands.create') }}'>Create Brand</a></li>
                        <li class="sidebar-item">
                            <a class='sidebar-link' href='{{ route('brands.index') }}'>List Brands</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a data-bs-target="#sales" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Sales</span>
                    </a>
                    <ul id="sales" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a class='sidebar-link' href='{{ route('sales.index') }}'>List Sales</a>
                        </li>
                        <li class="sidebar-item">
                            <a class='sidebar-link' href='{{ route('sales.commission') }}'>Sale's Commission</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a data-bs-target="#payments" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Payments</span>
                    </a>
                    <ul id="payments" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a class='sidebar-link' href='{{ route('admin.payments.topup.index') }}'>TopUp Request</a>
                        </li>
                        <li class="sidebar-item">
                            <a class='sidebar-link' href='{{ route('admin.payments.withdraw.index') }}'>Withdraw Request</a>
                        </li>
                    </ul>
                </li>

            @endif

            @if($role == 'user')
            <li class="sidebar-header pt-0">
                Main
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#product" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">TopUp</span>
                </a>
                <ul id="product" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' href='{{ route('payments.topup.create') }}'>TopUp Now</a></li>
                    <li class="sidebar-item">
                        <a class='sidebar-link' href='{{ route('payments.topup.index') }}'>TopUp History</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#Withdraw" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Withdraw</span>
                </a>
                <ul id="Withdraw" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a class='sidebar-link' href='{{ route('payments.withdraw.create') }}'>Withdraw Now</a>
                    </li>
                    <li class="sidebar-item">
                        <a class='sidebar-link' href='{{ route('payments.withdraw.index') }}'>Withdraw history</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#category" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Purchase</span>
                </a>
                <ul id="category" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('sales.index') }}">Purchase History</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('purchase.commission') }}">Purchase Commission's</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#Brand" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Refer</span>
                </a>
                <ul id="Brand" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' href=''>My Refer User's</a></li>
                    {{-- <li class="sidebar-item">
                        <a class='sidebar-link' href='{{ route('brands.index') }}'>List Brands</a>
                    </li> --}}
                </ul>
            </li>



            <li class="sidebar-item">
                <a data-bs-target="#Transfer" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Transfer</span>
                </a>
                <ul id="Transfer" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="">Transfer Request</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="">Transfer History</a>
                    </li>
                </ul>
            </li>
        @endif

        </ul>
    </div>
</nav>


