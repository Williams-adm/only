@extends('admin.templates.index')
@php
    $breadcrumName = 'SubCategorías';
    $route = 'admin.subcategories.create';
    $alertInfoMessage = 'Todavía no hay subcategorías registradas.';
@endphp

@section('headers')
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
        Acciones
    </th>
@endsection

@section('content-table')
    @foreach($data as $index => $subcategory)
        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 {{ !$loop->last ? 'border-b dark:border-gray-700 border-gray-200' : '' }}">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}
            </th>
            <td class="px-6 py-4">
                {{ $subcategory->name }}
            </td>
            <td class="px-6 py-4">
                {{ $subcategory->category->name }}
            </td>
            @include('admin.partials.tabla-acctions', ['item' => $subcategory, 'editRoute' => 'admin.subcategories.edit', 'deleteRoute' => 'admin.subcategories.destroy'])
        </tr>
    @endforeach
@endsection
