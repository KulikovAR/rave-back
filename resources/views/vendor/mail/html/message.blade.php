<x-mail::layout>
    {{-- Header --}}
    <x-slot:header>
        <div style="text-align: center">
            <x-mail::header :url="config('front-end.front_url')">
                <div style="display: flex; justify-content: center; gap: 8px; padding-bottom: 24px;">
                    <img src="{{asset('/assets/logo_big.png')}}" width="159" height="71"/>
                </div>
            </x-mail::header>
        </div>
    </x-slot:header>
    {{-- Body --}}
    {{ $slot }}
    {{-- Subcopy --}}
    @isset($subcopy)
        <x-slot:subcopy>
            <x-mail::subcopy>
                {{ $subcopy }}
            </x-mail::subcopy>
        </x-slot:subcopy>
    @endisset
    {{-- Footer --}}
    <x-slot:footer>
        <x-mail::footer>
            <div style="margin-top: 14px;">
                <p style="font-size: 14px; font-weight: 400; color: #8A8A8A;">Вы получили это письмо, потому что
                    ваши данные были использованы при регистрации на {{config('front-end.front_url')}}</p>
                <p style="font-size: 14px;font-weight: 400;color: #8A8A8A;">
                    По всем вопросам пишите на:
                    <a href="{{config('front-end.front_url')}}"
                       style="font-size: 20px; color: #000000; font-weight: 700;">
                        <br>
                        {{config('site-values.email_support.email_support')}}
                    </a>
                </p>
            </div>
        </x-mail::footer>
    </x-slot:footer>
</x-mail::layout>
