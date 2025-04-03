@extends('admin.templates.index')
@php
    $breadcrumName = 'Productos';
    $route = 'admin.products.create';
    $alertInfoMessage = 'Todavía no hay productos registrados.';
@endphp

@section('headers')
    <th scope="col" class="px-6 py-3">
        #
    </th>
    <th scope="col" class="px-6 py-3">
        SKU
    </th>
    <th scope="col" class="px-6 py-3">
        Nombre
    </th>
    <th scope="col" class="px-6 py-3">
        SubCategoría
    </th>
    <th scope="col" class="px-6 py-3">
        Acciones
    </th>
@endsection

@section('content-table')
    @foreach($data as $index => $product)
        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 {{ !$loop->last ? 'border-b dark:border-gray-700 border-gray-200' : '' }}">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}
            </th>
            <td class="px-6 py-4">
                {{ $product->sku }}
            </td>
            <td class="px-6 py-4">
                {{ $product->name }}
            </td>
            <td class="px-6 py-4">
                {{ $product->subCategory->name }}
            </td>
            @include('admin.partials.tabla-acctions2', ['item' => $product, 'showRoute' => 'admin.products.show', 'editRoute' => 'admin.products.edit', 'deleteRoute' => 'admin.products.destroy'])
        </tr>
    @endforeach
@endsection