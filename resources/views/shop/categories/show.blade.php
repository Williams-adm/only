<x-app-layout>
    <x-container class="px-4 my-4">
        <div>
            @include('shop.partials.breadcrumb', [
                'breadcrumbs' => [
                    [
                        'name' => $category->name
                    ]
                ]
            ])
        </div>
    </x-container>
    @livewire('shop.filter', [
        'category_id' => $category->id,
    ])
</x-app-layout>
