<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class='sidebar-brand' href='{{ url('super-admin') }}'>
            <span class="sidebar-brand-text align-middle">
                MyShopBd24
                <sup>
                    {{ auth()->user()->first()->name }}
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
                <a class="sidebar-link" href="{{route('super-admin')}}">
                    <i class="align-middle" data-feather="sliders"></i>  <span class="align-middle">Dashboard</span>
                </a>
            </li>
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
        </ul>
    </div>
</nav>
