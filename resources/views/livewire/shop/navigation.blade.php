<div x-data?="{
    open: false,    
}">
    <header class="bg-[#FEC51C]">
        <x-container class="px-4 py-4">
            <div class="flex items-center space-x-8 justify-between">

                <button class="text-2xl md:text-3xl" x-on:click="open = true">
                    <i class="fa-solid fa-list"></i>
                </button>

                <h1 class="text-black">
                    <a href="/" class="inline-flex flex-col items-end">
                        <span class="text-2xl  md:text-3xl leading-6 font-semibold">
                            Only Home
                        </span>
                    </a>
                </h1>

                <div class="flex-1 hidden md:block">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400" aria-hidden="true">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                        </div>
                        <x-search oninput="search(this.value)"></x-search>
                    </div>
                </div>

                <div class="space-x-8 flex items-center">
                    <x-dropdown>
                        <x-slot name="trigger">
                            @auth
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <button class="text-2xl md:text-3xl ">
                                    <i class="fa-solid fa-user"></i>
                                </button>
                            @endauth
                        </x-slot>

                        <x-slot name="content">
                            @guest
                                <div class="px-4 py-2">
                                    <div class="flex justify-center">
                                        <a href="{{ route('login') }}" class="btn3 btn-light2">
                                            Iniciar sesión
                                        </a>
                                    </div>
                                    
                                    <p class="text-sm text-center dark:text-white mt-3">
                                        <a href="{{ route('register') }}" class="hover:underline dark:hover:text-[#ffdf7e]">Regístrate</a>
                                    </p>
                                </div>
                            @else
                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    Mi perfil
                                </x-dropdown-link>

                                @if (count(Auth::user()->roles))
                                    <x-dropdown-link href="{{ route('admin.dashboard') }}" class="border-t border-gray-200 dark:border-gray-600">
                                        Admin
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200 dark:border-gray-600">
                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-dropdown-link href="{{ route('logout') }}"
                                            @click.prevent="$root.submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            @endguest
                        </x-slot>
                    </x-dropdown>
                    
                    <a href="{{ route('cart.index') }}" class="relative">
                        <i class="fa-solid fa-cart-shopping text-2xl md:text-3xl"></i>

                        <span id="cart-count" class="absolute -top-2 -end-4 inline-flex w-6 h-6 items-center justify-center bg-gray-100 rounded-full text-xs font-bold">
                            {{ Cart::instance('shopping')->count() }}
                        </span>
                    </a>
                </div>
            </div>
            
            <div class="mt-4 md:hidden">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <span class="text-gray-500 dark:text-gray-400" aria-hidden="true">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                    <x-search oninput="search(this.value)"></x-search>
                </div>
            </div>
        </x-container>
    </header>

    <div x-show="open" x-on:click="open = false" style="display: none" class="fixed top-0 left-0 inset-0 bg-black bg-opacity-20 z-10 dark:bg-white dark:bg-opacity-[0.12]"></div>
    <div x-show="open" style="display: none" class="fixed top-0 left-0 z-20">
        <div class="flex">
            <div class="w-80 h-screen bg-gray-100 dark:bg-gray-900 md:border-r-[1px] md:border-[#FEC51C]">
                <div class="bg-[#FEC51C] px-4 py-3 text-black font-semibold">
                    <div class="flex items-center justify-between">
                        <span class="text-lg">
                            @auth
                                ¡Hola! {{ Auth::user()->name }}
                            @else
                                ¡Hola!
                            @endauth
                        </span>
                        <button x-on:click="open = false">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>

                <div class="h-[calc(100vh-52px)] overflow-auto">
                    <ul>
                        @foreach ($families as $family)
                            <li wire:mouseover="$set('family_id', {{$family->id}})">
                                <a href="{{ route('families.show', $family) }}" class="flex items-center justify-between px-4 py-4 text-gray-700 dark:text-white hover:bg-[#ffdf7e] dark:hover:text-black">
                                    {{ $family->name }}
                                    <i class="fa-solid fa-angle-right fa-lg"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="w-80 xl:w-[57rem] pt-[52px] hidden md:block">
                <div class="h-[calc(100vh-52px)] overflow-auto bg-gray-100 dark:bg-gray-900 px-6 py-8">
                    <div class="mb-8 flex justify-between items-center">
                        <p class="border-b-[3px] border-[#E39F00] uppercase text-xl font-bold text-gray-700 dark:text-white">
                            <a href="{{ route('families.show', $family_id) }}" class="hover:text-black dark:hover:text-[#E39F00]">
                                {{ $this->familyName }}
                            </a>    
                        </p>

                        <a href="{{ route('families.show', $family_id) }}" class="btn3 btn-light2">
                            Ver Todo
                        </a>
                    </div>

                    <ul class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                        @foreach ($this->categories as $category)
                            <li>
                                <a href="{{ route('categories.show', $category) }}" class="text-gray-700 dark:text-white font-semibold text-lg pb-1 hover:text-black dark:hover:text-[#E39F00]">
                                    {{$category->name}}
                                </a>

                                <ul class="mt-4 space-y-2">
                                    @foreach ($category->subCategories as $subCategory)
                                        <li>
                                            <a href="{{ route('subcategories.show', $subCategory) }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-[#E39F00]">
                                                {{ $subCategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            Livewire.on('cartUpdated', (count) => {
                document.getElementById('cart-count').innerText = count;
            });

            function search(value) {
                Livewire.dispatch('search', {
                    search: value
                })
            }
        </script>
    @endpush
</div>
