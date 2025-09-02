<x-app-layout>
    <x-container class="px-4 my-4">
        <div>
            @include('shop.partials.breadcrumb', [
                'breadcrumbs' => [
                    [
                        'name' => $subcategory->category->name,
                        'route' => route('categories.show', $subcategory->category)
                    ],
                    [
                        'name' => $subcategory->name
                    ]
                ]
            ])
        </div>
    </x-container>
    @livewire('shop.filter', [
        'subcategory_id' => $subcategory->id,
    ])
</x-app-layout>
