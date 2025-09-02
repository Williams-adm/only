@php
    $links = [
        [
            'name' => 'Dashboard',
            'icon' => 'fa-solid fa-chart-line',
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard')
        ],
        [
            'name' => 'Usuarios',
            'icon' => 'fa-solid fa-users',
            'route' => route('admin.users.index'),
            'active' => request()->routeIs('admin.users.*')
        ],
        [
            'header' => 'Administrar página'
        ],
        [
            'name' => 'Opciones',
            'icon' => 'fa-solid fa-gear',
            'route' => route('admin.options.index'),
            'active' => request()->routeIs('admin.options.*')
        ],
        [
            //MARCA de productos
            'name' => 'Marcas',
            'icon' => 'fa-solid fa-layer-group',
            'route' => route('admin.brands.index'),
            'active' => request()->routeIs('admin.brands.*')
        ],
        [
            'name' => 'Categorías',
            'icon' => 'fa-solid fa-tags',
            'route' => route('admin.categories.index'),
            'active' => request()->routeIs('admin.categories.*')
        ],
        [
            'name' => 'SubCategorías',
            'icon' => 'fa-solid fa-list',
            'route' => route('admin.subcategories.index'),
            'active' => request()->routeIs('admin.subcategories.*')
        ],
        [
            'name' => 'Productos',
            'icon' => 'fa-solid fa-boxes-stacked',
            'route' => route('admin.products.index'),
            'active' => request()->routeIs('admin.products.*')
        ],
        [
            'name' => 'Portadas',
            'icon' => 'fa-solid fa-images',
            'route' => route('admin.covers.index'),
            'active' => request()->routeIs('admin.covers.*')
        ],
        [
            'header' => 'Ordenes y envío'
        ],
        [
            'name' => 'Couriers',
            'icon' => 'fa-solid fa-cart-flatbed',
            'route' => route('admin.shipping-companies.index'),
            'active' => request()->routeIs('admin.shipping-companies.*')
        ],
        [
            'name' => 'Órdenes',
            'icon' => 'fa-solid fa-cart-shopping',
            'route' => route('admin.orders.index'),
            'active' => request()->routeIs('admin.orders.*')
        ],
        [
            'name' => 'Envios',
            'icon' => 'fa-solid fa-truck-fast',
            'route' => route('admin.shipments.index'),
            'active' => request()->routeIs('admin.shipments.*')
        ],
    ];
@endphp

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-[100dvh] pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    :class="{
        'translate-x-0 ease-out' : sidebarOpen,
        '-translate-x-full ease-in' : !sidebarOpen
    }"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($links as $link)
                <li>
                    @isset($link['header'])
                        <div class="px-3 py-2 text-xs font-semibold dark:text-gray-300 text-gray-700 uppercase">
                            {{ $link['header'] }}
                        </div>
                    @else
                        @php
                            $activeClass = $link['active'] ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '';
                        @endphp
                        <a href="{{$link['route']}}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $activeClass }}">
                            <span class=" inline-flex w-6 h-6 justify-center items-center">
                                <i class="{{$link['icon']}} text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white {{ $activeClass }}"></i>
                            </span>
                            <span class="ms-2">
                                {{$link['name']}}
                            </span>
                        </a>
                    @endisset
                </li>
            @endforeach
        </ul>
    </div>
</aside>
