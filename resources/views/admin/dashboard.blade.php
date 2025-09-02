<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
    ],
]">
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-gray-900 dark:text-white">
        <div class="rounded-lg shadow-lg p-6 bg-gray-50 dark:bg-gray-800">
            <div class="flex items-center">
                <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                <div class="ml-4 flex-1">
                    <h2 class="text-lg font-semibold">
                        Bienvenido, {{ auth()->user()->name }}
                    </h2>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="text-sm">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="rounded-lg shadow-lg p-6 bg-gray-50 dark:bg-gray-800 flex items-center justify-center">
            <h2 class="text-xl font-semibold">
                ANTTEC
            </h2>
        </div>
    </section>
</x-admin-layout>
