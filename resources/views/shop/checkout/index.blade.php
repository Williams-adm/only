<x-app-layout>
    <div class="text-gray-800 dark:text-gray-200 mt-7" x-data="{
        pago: 1
    }">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="col-span-1 bg-white dark:bg-gray-800">
                <div class="lg:max-w-[45rem] py-10 px-4 lg:pr-8 sm:pl-6 lg:pl-8 ml-auto">
                    <h1 class="text-2xl mb-2 font-medium">
                        Pago
                    </h1>
                    <div class="shadow rounded-lg overflow-hidden border border-gray-600 dark:border-gray-300">
                        <ul class="divide-y divide-gray-800 dark:divide-gray-500">
                            <li>
                                <label class="p-4 flex items-center">
                                    <x-radio value="1" x-model="pago"></x-radio>
                                    <span class="ml-2">
                                        Tarjeta de debito / crédito
                                    </span>

                                    <img class="h-6 ml-auto" src="https://codersfree.com/img/payments/credit-cards.png" alt="">
                                </label>

                                <div class="p-4 bg-gray-100 dark:bg-gray-700 text-center border-t border-gray-600 dark:border-gray-300"
                                    x-show="pago == 1">
                                    <i class="fa-solid fa-credit-card text-9xl"></i>
                                    <p class="mt-2">
                                        Luego de hacer click al "Pagar ahora", se abrira el checkout de Niubiz para completar tu compra de forma segura.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-span-1">
                <div class="lg:max-w-[45rem] py-12 px-4 lg:pl-8 sm:pr-6 lg:pr-8 mr-auto">
                    <ul class="space-y-4 mb-4">
                        @foreach (Cart::instance('shopping')->content() as $item)
                            <li class="flex items-center space-x-4">
                                <div class="flex-shrink-0 relative">
                                    <img class="h-16 aspect-square" src="{{ Storage::url($item->options->image) }}" alt="">
                                    <div class="flex justify-center items-center h-6 w-6 bg-gray-900 dark:bg-gray-200 bg-opacity-70 rounded-full absolute -right-2 -top-2">
                                        <span class="font-semibold dark:text-gray-700">
                                            {{ $item->qty }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col">
                                        <span>
                                            {{ $item->name }} {{ $item->options->model }}
                                        </span>
                                        @foreach ($item->options->features as $featureId => $featureDescription)
                                                <p
                                                    class="{{ $item->qty > $item->options['stock'] ? 'text-red-600' : 'dark:text-gray-200 text-gray-800' }}">
                                                    {{ $item->options->option_names[$featureId] ?? 'Opción' }}:
                                                    {{ $featureDescription }}
                                                </p>
                                            @endforeach
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <p>
                                        S/. {{ $item->price }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="flex justify-between">
                        <p>
                            SubTotal
                        </p>
                        <p>
                            S/. {{ Cart::instance('shopping')->subtotal() }}
                        </p>
                    </div>

                    <div class="flex justify-between">
                        <p>
                            Precio de envío
                            <i class="fas fa-info-circle ml-1"
                            title="El precio del envío es de S/. 15.00"></i>
                        </p>
                        <p>
                            S/. 15.00
                        </p>
                    </div>

                    <hr class="my-4">

                    <div class="flex justify-between mb-4">
                        <p class="text-lg font-semibold">
                            Total
                        </p>
                        <p>
                            S/. {{Cart::instance('shopping')->subtotal() + 15 }}
                        </p>
                    </div>
                    <div>
                        <button class="btn btn-blue w-full" onclick="VisanetCheckout.open()">
                            Pagar Ahora
                        </button>
                    </div>
                    @if (session('niubiz'))
                        @php
                            $niubiz = session('niubiz');
                            $response = $niubiz['response'];
                            $purchaseNumber = $niubiz['purchaseNumber'];
                        @endphp

                        @isset($response['data'])
                            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 mt-6" role="alert">
                                <i class="fa-solid fa-triangle-exclamation shrink-0 inline me-3"></i>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium mb-4">{{ $response['data']['ACTION_DESCRIPTION'] }}</span>
                                    <p>
                                        <b>Número de pedido:</b>
                                        {{ $purchaseNumber }}
                                    </p>
                                    <p>
                                        <b>Fecha y hora del pedido:</b>
                                        {{ now()->createFromFormat('ymdHis', $response['data']['TRANSACTION_DATE'])->format('d-m-Y H:i:s') }}
                                    </p>

                                    @isset($response['data']['CARD'])
                                        <p>
                                            <b>Tarjeta:</b>
                                            {{ $response['data']['CARD'] }} ({{ $response['data']['BRAND'] }})
                                        </p>
                                    @endisset
                                </div>
                            </div>
                        @endisset
                    @else

                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script type="text/javascript" src="{{ config('services.niubiz.url_js') }}">
        </script>

        <script type="text/javascript">

            document.addEventListener('DOMContentLoaded', function(){
                let purchasenumber = Math.floor(Math.random() * 1000000000);
                let amount = {{Cart::instance('shopping')->subtotal() + 15 }};

                VisanetCheckout.configure({
                    sessiontoken:'{{ $sessionToken }}',
                    channel:'web',
                    merchantid:"{{ config('services.niubiz.merchant_id') }}",
                    purchasenumber:purchasenumber,
                    amount: amount,
                    expirationminutes:'20',
                    timeouturl:'about:blank',
                    merchantlogo:'img/comercio.png',
                    formbuttoncolor:'#000000',
                    action:"{{ route('checkout.paid') }}?amount=" + amount + "&purchaseNumber=" + purchasenumber,
                    complete: function(params) {
                        alert(JSON.stringify(params));
                    }
                });
            });


        </script>
    @endpush
</x-app-layout>
