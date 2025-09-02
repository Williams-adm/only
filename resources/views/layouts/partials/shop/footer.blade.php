<footer class="bg-[#5A2867]">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0 flex items-center justify-center">
                <a href="/" class="inline-flex flex-col items-end">
                    <img src="{{asset('assets/img/logo.png')}}" alt="logo" class="w-36">
                </a>
            </div>
            <div class="">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-100 uppercase">Legal</h2>
                    <ul class="text-gray-200 font-medium">
                        <li class="mb-4">
                            <a href="{{ route('legal.privacy-policy') }}" class="hover:underline">Políticas de privacidad</a>
                        </li>
                        <li>
                            <a href="{{ route('legal.terms-and-conditions') }}" class="hover:underline">Términos y condiciones</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 sm:mx-auto border-gray-300 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-200 sm:text-center">© 2025 <a href="/" class="hover:underline">ANTTEC</a>. All Rights Reserved.
            </span>
            <div class="flex mt-4 sm:justify-center sm:mt-0">
                <a href="https://www.facebook.com/share/15KfQnuHvN/" target="__blank" class="text-gray-300 hover:text-white">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="https://api.whatsapp.com/send?phone=51964645037" target="__blank" class="text-gray-300 hover:text-white ms-5">
                    <i class="fa-brands fa-whatsapp fa-lg"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
