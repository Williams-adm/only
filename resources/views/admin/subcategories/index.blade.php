<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'SubCategorías',
    ],
]">

    <x-slot name="action">
        <a class="btn btn-blue" href="{{ route('admin.subcategories.create') }}">
            Crear
        </a>
    </x-slot>

    @if ($subCategories->count())
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Categoría
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Familia
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subCategories as $index => $subcategory)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 {{ !$loop->last ? 'border-b dark:border-gray-700 border-gray-200' : ''}}">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ ($subCategories->currentPage() - 1) * $subCategories->perPage() + $index + 1 }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $subcategory->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $subcategory->category->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $subcategory->category->family->name }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-between">
                                    <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="font-medium text-blue-600 dark:text-blue-500">
                                        <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                    </a>
                                    <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST" id="delete-form-{{ $subcategory->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="font-medium text-red-600 dark:text-red-500" onclick="confirmDelte({{ $subcategory->id }})">
                                            <i class="fa-solid fa-trash-can fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($subCategories->lastPage() > 1)
            <div class="mt-4">
                {{ $subCategories->links() }}
            </div>
        @endif
    @else
        <div class="flex items-center p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Alerta Informativa!</span> Todavía no hay categorias registrados.
            </div>
        </div>
    @endif
</x-admin-layout>
